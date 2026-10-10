<?php

namespace App\Http\Controllers\Frontend;

// use App\Models\User;

use app\Domains\Auth\Models\User;
use App\Notifications\BookingNotification;
use App\Http\Controllers\Controller;
use App\Models\Room;
use Carbon\Carbon;
use App\Models\Booking1;
use App\Models\Guest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;
use Razorpay\Api\Api;


class BookingsController extends Controller
{


    public function create(Request $request, Room $room)
    {
        $search = $request->validate([
            'check_in' => ['nullable', 'required_with:check_out', 'date_format:Y-m-d', 'after_or_equal:today'],
            'check_out' => ['nullable', 'required_with:check_in', 'date_format:Y-m-d', 'after:check_in'],
            'guests' => ['nullable', 'required_with:check_in,check_out', 'integer', 'min:1', 'max:20'],
        ]);
        $guestCount = isset($search['guests']) ? (int) $search['guests'] : 1;
        $room->load('roomType');

        $isAvailable = Room::query()
            ->whereKey($room->id)
            ->bookable($guestCount)
            ->availableForStay($search['check_in'] ?? null, $search['check_out'] ?? null)
            ->exists();

        if (!$isAvailable) {
            return redirect()
                ->route('frontend.room.index', $search)
                ->withFlashDanger('This room is no longer available for your selected stay.');
        }

        return view('frontend.bookings.create', compact('room', 'search', 'guestCount'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'room_id' => 'required|exists:rooms,id',
            'check_in' => 'required|date|after_or_equal:today',
            'check_out' => 'required|date|after:check_in',
            'adults' => 'required|integer|min:1|max:20',
            'children' => 'nullable|integer|min:0|max:20',
        ]);

        $user = Auth::user();
        $guestCount = (int) $data['adults'] + (int) ($data['children'] ?? 0);

        $booking = DB::transaction(function () use ($data, $user, $guestCount) {
            $room = Room::with('roomType')
                ->whereKey($data['room_id'])
                ->lockForUpdate()
                ->firstOrFail();

            $isAvailable = Room::query()
                ->whereKey($room->id)
                ->bookable($guestCount)
                ->availableForStay($data['check_in'], $data['check_out'])
                ->exists();

            if (!$isAvailable) {
                throw ValidationException::withMessages([
                    'room_id' => 'This room is no longer available for the selected dates or guest count.',
                ]);
            }

            $name = explode(' ', trim($user->name), 2);
            $guest = Guest::firstOrCreate(
                ['email' => $user->email],
                [
                    'first_name' => $name[0] ?? '',
                    'last_name' => $name[1] ?? '',
                    'phone' => $user->phone ?? '',
                    'status' => true,
                ]
            );

            $nights = Carbon::parse($data['check_in'])->diffInDays(Carbon::parse($data['check_out']));

            return Booking1::create([
                'booking_no' => 'BK-' . uniqid(),
                'guest_id' => $guest->id,
                'room_id' => $room->id,
                'check_in' => $data['check_in'],
                'check_out' => $data['check_out'],
                'adults' => $data['adults'],
                'children' => $data['children'] ?? 0,
                'total_amount' => $room->roomType->price * $nights,
                'booking_status' => 'Pending',
                'payment_status' => 'Pending',
                'remarks' => null,
                'status' => true,
            ]);
        });

        $admins = User::where('type', User::TYPE_ADMIN)->get();
        
        foreach ($admins as $admin) {
            $admin->notify(
                new BookingNotification($booking)
            );
        }


        return redirect()
            ->route('frontend.room.index')
            ->withFlashSuccess('Booking submitted successfully.');
    }

    public function show(Booking1 $booking)
    {
        $booking->load([
            'room.roomType',
            'guest',
        ]);

        if ($booking->guest->email !== Auth::user()->email) {
            abort(403);
        }

        return view(
            'frontend.bookings.show',
            compact('booking')
        );
    }

    public function cancel(Booking1 $booking)
    {
        $booking->load('guest');

        if ($booking->guest->email !== Auth::user()->email) {
            abort(403);
        }

        if (!in_array($booking->booking_status, ['Pending', 'Confirmed'])) {
            return back()->withFlashDanger(
                'This booking cannot be cancelled.'
            );
        }

        $booking->update([
            'booking_status' => 'Cancelled',
        ]);

        return back()->withFlashSuccess(
            'Booking cancelled successfully.'
        );
    }
}