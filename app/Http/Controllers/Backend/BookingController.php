<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
// use App\Models\User;
use App\Domains\Auth\Models\User;
use App\Notifications\BookingNotification;
use App\Models\Guest;
use App\Services\ActivityLogService;
use App\Models\Booking;
use App\Models\Invoice;
use App\Models\Room;
use App\Services\BookingService;
use App\Http\Requests\StoreBookingRequest;
use App\Http\Requests\UpdateBookingRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class BookingController extends Controller
{
    /**
     * @var BookingService
     */
    protected $service;

    /**
     * Constructor
     */
    protected $activityLog;

    public function __construct(
        BookingService $service,
        ActivityLogService $activityLog
    ) {
        $this->service = $service;
        $this->activityLog = $activityLog;
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $bookings = $this->service->all(5, $request->search);

        return view('backend.bookings.index', compact('bookings'));
    }

    public function checkInIndex(Request $request)
    {
        $bookings = $this->service->all(5, $request->search, 'Confirmed');
        $bookingPageTitle = 'Check In';

        return view('backend.bookings.index', compact('bookings', 'bookingPageTitle'));
    }

    public function checkOutIndex(Request $request)
    {
        $bookings = $this->service->all(5, $request->search, 'Checked In');
        $bookingPageTitle = 'Check Out';

        return view('backend.bookings.index', compact('bookings', 'bookingPageTitle'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $guests = Guest::all();
        $rooms = Room::all();

        return view(
            'backend.bookings.create',
            compact('guests', 'rooms')
        );
    }

    /**
     * Store a newly created resource.
     */
    public function store(StoreBookingRequest $request)
    {
        $booking = $this->service->store($request->validated());

        $this->activityLog->log(
            'Booking',
            'Created',
            'Booking #' . $booking->id . ' created by ' . auth()->user()->name
        );

        return redirect()
            ->route('admin.bookings.index')
            ->with('success', 'Booking created successfully.');
    }
    public function edit(Booking $booking)
    {
        $guests = Guest::all();
        $rooms = Room::all();

        return view(
            'backend.bookings.edit',
            compact('booking', 'guests', 'rooms')
        );
    }

    /**
     * Update the specified resource.
     */
    public function update(
        UpdateBookingRequest $request,
        Booking $booking
    ) {
        $this->service->update(
            $booking,
            $request->validated()
        );
        $this->activityLog->log(
            'Booking',
            'Updated',
            'Booking #' . $booking->id . ' updated by ' . auth()->user()->name
        );

        return redirect()
            ->route('admin.bookings.index')
            ->withFlashSuccess('Bookings Updated Successfully.');
    }

    /**
     * Remove the specified resource.
     */
    public function destroy(Booking $booking)
    {
        $this->activityLog->log(
            'Booking',
            'Deleted',
            'Booking #' . $booking->id . ' deleted by ' . auth()->user()->name
        );

        $this->service->delete($booking);

        return redirect()
            ->route('admin.bookings.index')
            ->with('success', 'Booking deleted successfully.');
    }

    /**
     * Show booking details.
     */
    public function show(Booking $booking)
    {
        $booking->load([
            'guest',
            'room.roomType',
        ]);

        return view(
            'backend.bookings.show',
            compact('booking')
        );
    }

    /**
     * Confirm booking.
     */
    public function confirm($id)
    {
        $booking = Booking::findOrFail($id);

        $booking->update([
            'booking_status' => 'Confirmed',
        ]);

        $this->activityLog->log(
            'Booking',
            'Confirmed',
            'Booking #' . $booking->id . ' confirmed by ' . auth()->user()->name
        );

        return redirect()
            ->back()
            ->with('success', 'Booking confirmed successfully.');
    }

    /**
     * Cancel booking.
     */
    public function cancel($id)
    {
        $booking = Booking::findOrFail($id);

        $booking->update([
            'booking_status' => 'Cancelled',
        ]);
        $this->activityLog->log(
            'Booking',
            'Cancelled',
            'Booking #' . $booking->id . ' cancelled by ' . auth()->user()->name
        );

        return redirect()
            ->back()
            ->with('error', 'Booking cancelled.');
    }

    /**
     * Check in guest.
     */
    public function checkIn($id)
    {
        $booking = Booking::with('room')->findOrFail($id);

        if ($booking->booking_status !== 'Confirmed') {
            return redirect()->back()->with('error', 'Only confirmed bookings can be checked in.');
        }

        if (!$booking->room || $booking->room->status !== 'available') {
            return redirect()->back()->with('error', 'The assigned room is not available.');
        }

        DB::transaction(function () use ($booking) {
            $booking->update(['booking_status' => 'Checked In']);
            $booking->room->update(['status' => 'occupied']);
        });
        $this->activityLog->log(
            'Booking',
            'Checked In',
            'Guest checked in for Booking #' . $booking->id
        );

        return redirect()
            ->back()
            ->with('success', 'Guest checked in successfully.');
    }

    /**
     * Check out guest and automatically create invoice.
     */
    public function checkOut($id)
    {
        $booking = Booking::with('room')->findOrFail($id);

        if ($booking->booking_status !== 'Checked In') {
            return redirect()->back()->with('error', 'Only checked-in bookings can be checked out.');
        }

        DB::transaction(function () use ($booking) {
            $booking->update(['booking_status' => 'Checked Out']);
            if ($booking->room) {
                $booking->room->update(['status' => 'available']);
            }

            Invoice::firstOrCreate(
                ['booking_id' => $booking->id],
                [
                    'invoice_no' => 'INV-' . time(),
                    'room_charge' => $booking->total_amount,
                    'extra_charge' => 0,
                    'tax' => 0,
                    'discount' => 0,
                    'total_amount' => $booking->total_amount,
                    'payment_method' => null,
                    'payment_status' => 'Pending',
                    'paid_amount' => 0,
                    'remarks' => null,
                    'status' => true,
                ]
            );
        });
        $this->activityLog->log(
            'Booking',
            'Checked Out',
            'Guest checked out for Booking #' . $booking->id
        );

        $this->activityLog->log(
            'Invoice',
            'Generated',
            'Invoice generated for Booking #' . $booking->id
        );

        return redirect()
            ->back()
            ->withFlashSuccess(
                'Guest checked out and invoice created successfully.'
            );
    }
}