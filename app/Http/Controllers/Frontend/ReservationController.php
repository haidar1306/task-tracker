<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\Guest;
use App\Models\ExternalBooking;
use Illuminate\Support\Facades\Auth;

class ReservationController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        // Existing local room reservations
        $guest = Guest::where('email', $user->email)->first();
        $reservations = Booking::with([
            'room.roomType',
            'invoice',
        ])
            ->when($guest, function ($query) use ($guest) {
                $query->where('guest_id', $guest->id);
            })
            ->when(!$guest, function ($query) {
                $query->whereRaw('1 = 0');
            })
            ->latest()
            ->paginate(10, ['*'], 'local_page');

        $dubaiPaidCount = ExternalBooking::where('user_id', $user->id)
            ->where('payment_status', 'paid')
            ->count();

        $dubaiUnpaidCount = ExternalBooking::where('user_id', $user->id)
            ->where(function ($query) {
                $query->whereNull('payment_status')
                    ->orWhere('payment_status', '!=', 'paid');
            })
            ->count();


        // Dubai / external hotel reservations
        $externalReservations = ExternalBooking::where('user_id', $user->id)
            ->latest()
            ->paginate(10, ['*'], 'dubai_page');


        return view('reservation.index', compact(
            'reservations',
            'externalReservations',
            'dubaiPaidCount',
            'dubaiUnpaidCount'
        ));

    }

    public function show(Booking $reservation)
    {
        $guest = Guest::where('email', Auth::user()->email)->first();

        if (!$guest) {
            return redirect()
                ->route('frontend.reservation.index')
                ->withFlashDanger('Guest record not found.');
        }

        if ($reservation->guest_id != $guest->id) {
            abort(403);
        }

        $reservation->load('room.roomType');

        return view('reservation.show', compact('reservation'));
    }
}
