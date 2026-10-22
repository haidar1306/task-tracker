<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreBookingRequest;
use App\Http\Requests\UpdateBookingRequest;
use App\Models\Booking;
use App\Models\Guest;
use App\Models\Room;
use App\Services\ActivityLogService;
use App\Services\BookingService;
use Closure;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class BookingController extends Controller
{
    protected $service;
    protected $activityLog;

    public function __construct(BookingService $service, ActivityLogService $activityLog)
    {
        $this->service = $service;
        $this->activityLog = $activityLog;
    }

    /* ---------------- Lists ---------------- */

    public function index(Request $request)
    {
        $bookings = $this->service->all(10, $request->search);

        return view('backend.bookings.index', compact('bookings'));
    }

    public function checkInIndex(Request $request)
    {
        $bookings = $this->service->all(10, $request->search, Booking::STATUS_CONFIRMED);
        $bookingPageTitle = 'Check In';

        return view('backend.bookings.index', compact('bookings', 'bookingPageTitle'));
    }

    public function checkOutIndex(Request $request)
    {
        $bookings = $this->service->all(10, $request->search, Booking::STATUS_CHECKED_IN);
        $bookingPageTitle = 'Check Out';

        return view('backend.bookings.index', compact('bookings', 'bookingPageTitle'));
    }

    /* ---------------- Create / Edit ---------------- */

    public function create()
    {
        return view('backend.bookings.create', [
            'guests' => Guest::orderBy('first_name')->get(),
            'rooms' => $this->selectableRooms(),
        ]);
    }

    public function store(StoreBookingRequest $request): RedirectResponse
    {
        $booking = $this->service->createByAdmin($request->validated());

        $this->activityLog->log(
            'Booking',
            'Created',
            'Booking #' . $booking->id . ' created by ' . auth()->user()->name
        );

        return redirect()
            ->route('admin.bookings.index')
            ->withFlashSuccess('Booking created successfully.');
    }

    public function edit(Booking $booking)
    {
        return view('backend.bookings.edit', [
            'booking' => $booking,
            'guests' => Guest::orderBy('first_name')->get(),
            'rooms' => $this->selectableRooms((int) $booking->room_id),
        ]);
    }

    public function update(UpdateBookingRequest $request, Booking $booking): RedirectResponse
    {
        $this->service->update($booking, $request->validated());

        $this->activityLog->log(
            'Booking',
            'Updated',
            'Booking #' . $booking->id . ' updated by ' . auth()->user()->name
        );

        return redirect()
            ->route('admin.bookings.index')
            ->withFlashSuccess('Booking updated successfully.');
    }

    public function show(Booking $booking)
    {
        $booking->load(['guest', 'room.roomType', 'invoice']);

        return view('backend.bookings.show', compact('booking'));
    }

    public function destroy(Booking $booking): RedirectResponse
    {
        try {
            $this->service->delete($booking);
        } catch (ValidationException $e) {
            return redirect()->back()->withFlashDanger($e->validator->errors()->first());
        }

        $this->activityLog->log(
            'Booking',
            'Deleted',
            'Booking #' . $booking->id . ' deleted by ' . auth()->user()->name
        );

        return redirect()->route('admin.bookings.index')->withFlashSuccess('Booking deleted successfully.');
    }

    /* ---------------- Status actions (sirf POST) ---------------- */

    public function confirm(Booking $booking): RedirectResponse
    {
        return $this->act(
            $booking,
            'Confirmed',
            'Booking confirmed successfully.',
            fn() => $this->service->confirm($booking)
        );
    }

    public function reject(Booking $booking): RedirectResponse
    {
        return $this->act(
            $booking,
            'Rejected',
            'Booking rejected.',
            fn() => $this->service->reject($booking)
        );
    }

    public function cancel(Booking $booking): RedirectResponse
    {
        return $this->act(
            $booking,
            'Cancelled',
            'Booking cancelled.',
            fn() => $this->service->cancel($booking)
        );
    }

    public function noShow(Booking $booking): RedirectResponse
    {
        return $this->act(
            $booking,
            'No Show',
            'Booking marked as no-show.',
            fn() => $this->service->markNoShow($booking)
        );
    }

    public function checkIn(Booking $booking): RedirectResponse
    {
        return $this->act(
            $booking,
            'Checked In',
            'Guest checked in successfully.',
            fn() => $this->service->checkIn($booking)
        );
    }

    public function checkOut(Booking $booking): RedirectResponse
    {
        return $this->act(
            $booking,
            'Checked Out',
            'Guest checked out and invoice created successfully.',
            fn() => $this->service->checkOut($booking)
        );
    }

    /* ---------------- Helpers ---------------- */

    private function act(Booking $booking, string $label, string $success, Closure $callback): RedirectResponse
    {
        try {
            $callback();
        } catch (ValidationException $e) {
            return redirect()->back()->withFlashDanger($e->validator->errors()->first());
        }

        $this->activityLog->log(
            'Booking',
            $label,
            'Booking #' . $booking->id . ' ' . strtolower($label) . ' by ' . auth()->user()->name
        );

        return redirect()->back()->withFlashSuccess($success);
    }

    /** Maintenance wale rooms dropdown me nahi (edit me current room rehta hai). */
    private function selectableRooms(?int $includeRoomId = null)
    {
        return Room::with('roomType')
            ->where(function ($q) use ($includeRoomId) {
                $q->where('status', '!=', 'maintenance');

                if ($includeRoomId) {
                    $q->orWhere('id', $includeRoomId);
                }
            })
            ->orderBy('room_number')
            ->get();
    }
}