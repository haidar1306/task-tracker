<?php

namespace App\Http\Controllers\Frontend;

use App\Domains\Website\Models\GeneralSetting;
use App\Models\Booking1;
use App\Models\Guest;
use Illuminate\Support\Facades\Auth;

class HomeController
{
    public function index()
    {
        $setting = GeneralSetting::first();

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

        return view('frontend.user.dashboard', compact(
            'setting',
            'reservations'
        ));
    }
}