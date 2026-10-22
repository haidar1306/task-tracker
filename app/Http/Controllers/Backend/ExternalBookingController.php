<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Domains\Auth\Models\User;
use App\Models\ExternalBooking;
use App\Notifications\ExternalBookingNotification;
use App\Services\ActivityLogService;    
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ExternalBookingController extends Controller
{
    public function __construct(
        protected ActivityLogService $activityLog
    ) {
    }

    public function index(Request $request)
    {
        $bookings = ExternalBooking::query()
            ->when($request->filled('search'), function ($query) use ($request) {
                $search = $request->search;

                $query->where(function ($q) use ($search) {
                    $q->where('booking_reference', 'like', "%{$search}%")
                        ->orWhere('hotel_name', 'like', "%{$search}%");
                });
            })
            ->latest()
            ->paginate(10)
            ->withQueryString();

        return view('backend.external-bookings.index', compact('bookings'));
    }

    public function show(ExternalBooking $externalBooking)
    {
        return view('backend.external-bookings.show', [
            'booking' => $externalBooking,
        ]);
    }

    public function confirm(ExternalBooking $externalBooking)
    {
        if (strtolower($externalBooking->status) !== 'pending') {
            return back()->with('error', 'Only pending bookings can be confirmed.');
        }

        $externalBooking->status = 'confirmed';
        $externalBooking->save();

        $this->notifyAdmins(
            $externalBooking,
            'Dubai Booking Confirmed',
            'Booking ' . $this->reference($externalBooking) . ' has been confirmed.'
        );

        $this->notifyUser(
            $externalBooking,
            'Booking Confirmed',
            'Your booking for ' . $externalBooking->hotel_name . ' has been confirmed.'
        );

        $this->logAction($externalBooking, 'Confirmed');

        return back()->with('success', 'Booking confirmed successfully.');
    }

    public function checkIn(ExternalBooking $externalBooking)
    {
        if (strtolower($externalBooking->status) !== 'confirmed') {
            return back()->with('error', 'Only confirmed bookings can be checked in.');
        }

        $externalBooking->status = 'checked_in';
        $externalBooking->save();

        $this->notifyUser(
            $externalBooking,
            'Dubai Hotel Check-in',
            'Check-in has been recorded for ' . $externalBooking->hotel_name . '.'
        );

        $this->logAction($externalBooking, 'Checked In');

        return back()->with('success', 'Check-in recorded successfully.');
    }

    public function checkOut(ExternalBooking $externalBooking)
    {
        if (strtolower($externalBooking->status) !== 'checked_in') {
            return back()->with('error', 'Only checked-in bookings can be checked out.');
        }

        $externalBooking->status = 'checked_out';
        $externalBooking->save();

        $this->notifyUser(
            $externalBooking,
            'Dubai Hotel Check-out',
            'Check-out is complete for ' . $externalBooking->hotel_name
                . '. You can now proceed to payment from My Reservations.'
        );

        $this->logAction($externalBooking, 'Checked Out');

        return back()->with('success', 'Check-out completed. Payment is now available to the user.');
    }

    private function notifyAdmins(
        ExternalBooking $booking,
        string $title,
        string $message
    ): void {
        User::where('type', User::TYPE_ADMIN)
            ->get()
            ->each(function ($admin) use ($booking, $title, $message) {
                $admin->notify(
                    new ExternalBookingNotification(
                        $booking,
                        $title,
                        $message,
                        'admin'
                    )
                );
            });
    }

    private function notifyUser(
        ExternalBooking $booking,
        string $title,
        string $message
    ): void {
        $user = User::find($booking->user_id);

        if ($user) {
            $user->notify(
                new ExternalBookingNotification(
                    $booking,
                    $title,
                    $message,
                    'user'
                )
            );
        }
    }

    private function reference(ExternalBooking $booking): string
    {
        return $booking->booking_reference ?: '#' . $booking->id;
    }

    private function logAction(
        ExternalBooking $booking,
        string $action
    ): void {
        $this->activityLog->log(
            'External Booking',
            $action,
            'External booking ' . $this->reference($booking)
                . ' — ' . $booking->hotel_name
                . ' — action by ' . auth()->user()->name
        );
    }
}