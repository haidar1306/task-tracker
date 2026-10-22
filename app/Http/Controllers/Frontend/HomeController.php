<?php

namespace App\Http\Controllers\Frontend;

use App\Models\Booking1;
use App\Models\Guest;
use App\Models\Room;
use App\Models\RoomType;
use Illuminate\Support\Facades\Auth;

class HomeController
{
    public function index()
    {
        $rooms = Room::with(['roomType', 'amenities'])
            ->whereHas('roomType')
            ->orderBy('room_type_id')
            ->orderBy('room_number')
            ->get();

        $reservations = collect();

        if (Auth::check()) {

            $guest = Guest::where('email', Auth::user()->email)->first();

            if ($guest) {

                $reservations = Booking1::with([
                    'room.roomType',
                    'invoice'
                ])
                    ->where('guest_id', $guest->id)
                    ->latest()
                    ->get();

            }
        }

        $featuredRoomTypes = RoomType::where('status', 1)
            ->latest()
            ->take(3)
            ->get();

        return view('frontend.user.dashboard', compact(
            'reservations',
            'rooms',
            'featuredRoomTypes'
        ));
    }
}