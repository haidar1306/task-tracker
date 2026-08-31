<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Room;

class RoomController extends Controller
{

    public function index()
    {
        $rooms = Room::with('roomType','amenities')
            ->where('status', 'available','occupied')
            ->get();

        return view(
            'frontend.room.index',
            compact('rooms')
        );
    }


    public function show(Room $room)
{
    $room->load([
        'roomType',
        'amenities'
    ]);

    return view(
        'frontend.room.show',
        compact('room')
    );
}

}