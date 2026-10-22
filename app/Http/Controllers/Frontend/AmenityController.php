<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Amenity;

class AmenityController extends Controller
{
    public function index()
    {
        $amenities = Amenity::where('status', 1)
            ->orderBy('id', 'asc')
            ->get();

        return view('frontend.amenities.index', compact('amenities'));
    }
}
