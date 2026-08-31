<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;

class HotelUpdatesController extends Controller
{
    public function index()
    {
        return view('frontend.hotel-updates.index');
    }
}
