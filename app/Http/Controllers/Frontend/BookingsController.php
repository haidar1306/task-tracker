<?php

namespace App\Http\Controllers\Frontend;

use App\Domains\Auth\Models\User;
use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\Booking1;
use App\Models\Guest;
use App\Models\Room;
use App\Notifications\BookingNotification;
use App\Services\BookingService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use App\Services\ActivityLogService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;

class BookingsController extends Controller
{
    protected $service;
    protected $activityLog;

    public function __construct(BookingService $service,ActivityLogService $activityLog)
    {
        $this->service = $service;
        $this->activityLog = $activityLog;
    }

    /** My bookings. */
    public function index()
    {
        $user = Auth::user();
        $guest = Guest::where('user_id', $user->id)->first()
            ?? Guest::where('email', $user->email)->first();

        $bookings = Booking::with('room.roomType')
            ->where('guest_id', $guest->id ?? 0)
            ->latest()
            ->paginate(10);

        return view('frontend.bookings.index', compact('bookings'));
    }

    /** Booking form. */
    public function create(Request $request, Room $room)
    {
        $search = $request->validate([
            'check_in' => ['nullable', 'required_with:check_out', 'date_format:Y-m-d', 'after_or_equal:today'],
            'check_out' => ['nullable', 'required_with:check_in', 'date_format:Y-m-d', 'after:check_in'],
            'guests' => ['nullable', 'required_with:check_in,check_out', 'integer', 'min:1', 'max:20'],
        ], $this->dateMessages());

        $guestCount = (int) ($search['guests'] ?? 1);

        $room->load('roomType');

        if (!$this->service->canBook($room, $guestCount, $search['check_in'] ?? null, $search['check_out'] ?? null)) {
            return redirect()
                ->route('frontend.room.index', $search)
                ->withErrors(['check_in' => 'this room is not avilable for selected dates.'])
                ->withInput();
        }

        // Har form load par naya token: double click / retry ek hi booking banata hai.
        $idempotencyKey = (string) Str::uuid();

        return view('frontend.bookings.create', compact('room', 'search', 'guestCount', 'idempotencyKey'));
    }

    /** Booked date ranges (calendar). */
    public function bookedDates(Room $room): JsonResponse
    {
        $ranges = Booking::query()
            ->where('room_id', $room->id)
            ->whereNotIn('booking_status', Booking::INACTIVE_STATUSES)
            ->whereDate('check_out', '>', now()->toDateString())
            ->get(['check_in', 'check_out'])
            ->map(fn(Booking $booking) => [
                'from' => $booking->check_in->toDateString(),
                // Check-out din free hai, isliye ek din pehle tak block.
                'to' => $booking->check_out->copy()->subDay()->toDateString(),
            ])
            ->values();

        return response()->json($ranges);
    }

    /** Save booking. */
    public function store(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'room_id' => ['required', 'integer', 'exists:rooms,id'],
            'check_in' => ['required', 'date_format:Y-m-d', 'after_or_equal:today'],
            'check_out' => ['required', 'date_format:Y-m-d', 'after:check_in'],
            'adults' => ['required', 'integer', 'min:1', 'max:20'],
            'children' => ['nullable', 'integer', 'min:0', 'max:20'],
            'idempotency_key' => ['nullable', 'string', 'max:64'],
        ], $this->dateMessages());

        $user = Auth::user();

        abort_unless($user, 401);

        [$booking, $created] = $this->service->createForUser($user, $data);

        if ($created) {
            app(ActivityLogService::class)->log(
                'Booking',
                'Created',
                'Booking #' . $booking->id . ' created by ' . $user->name
            );

            $this->notifyAdmins($booking);
        }

        return redirect()
            ->route('bookings.show', $booking)
            ->withFlashSuccess(
                'Booking successful! Your reservation has been submitted and is awaiting admin confirmation.'
            );
    }
    public function show(Booking $booking)
    {
        $booking->load(['room.roomType', 'guest', 'invoice']);

        $this->authorizeOwner($booking);

        return view('frontend.bookings.show', compact('booking'));
    }

    public function cancel(Booking $booking): RedirectResponse
    {
        $booking->load(['guest', 'invoice']);

        $this->authorizeOwner($booking);

        if (!$booking->isCancellableByGuest()) {
            return back()->withFlashDanger('Only unpaid reservations that have not checked in can be cancelled.');
        }

        try {
            $this->service->cancel($booking);
        } catch (ValidationException $e) {
            return back()->withFlashDanger($e->validator->errors()->first());
        }

        return back()->withFlashSuccess('Booking cancelled successfully.');
    }

    /* ---------------- Helpers ---------------- */

    private function authorizeOwner(Booking $booking): void
    {
        $user = Auth::user();

        $owns = $user
            && $booking->guest
            && (
                (int) $booking->guest->user_id === (int) $user->id
                || strcasecmp((string) $booking->guest->email, (string) $user->email) === 0
            );

        abort_unless($owns, 403);
    }

    private function notifyAdmins(Booking $booking): void
    {
        try {
            // Notification Booking1 expect kar sakta hai; Booking1 Booking ka child hai, dono chalte hain.
            $payload = Booking1::findOrFail($booking->id);

            User::where('type', User::TYPE_ADMIN)->get()
                ->each(fn(User $admin) => $admin->notify(new BookingNotification($payload)));
        } catch (\Throwable $e) {
            report($e);
        }
    }

    private function dateMessages(): array
    {
        return [
            'check_in.after_or_equal' => 'check in date can not be in the past.',
            'check_in.required_with' => 'Please select a check-in date.',
            'check_in.required' => 'please select a check-in date.',
            'check_out.after' => 'Check-out must be after check-in.',
            'check_out.required_with' => 'Please select a check-out date.',
            'check_out.required' => 'Please select a check-out date.',
        ];
    }
}