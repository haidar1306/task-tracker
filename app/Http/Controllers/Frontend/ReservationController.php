<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\Guest;
use Illuminate\Support\Facades\Auth;

class ReservationController extends Controller
{
   public function index()
{
    $guest = Guest::where('email', Auth::user()->email)->first();

    if (!$guest) {

        return redirect()
            ->back()
            ->withFlashDanger('Guest record not found.');

    }

   $reservations = Booking::with([
        'room.roomType',
        'invoice'
    ])
    ->where('guest_id', $guest->id)
    ->latest()
    ->paginate(10);

    return view('reservation.index', compact('reservations'));
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