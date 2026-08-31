<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\RoomType;

class RoomTypeController extends Controller
{
   public function index()
{
    $roomTypes = RoomType::where('status', true)
        ->orderBy('name')
        ->paginate(5);

    return view(
        'frontend.room-types.index',
        compact('roomTypes')
    );
}
}