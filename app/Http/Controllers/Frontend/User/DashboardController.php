<?php

namespace App\Http\Controllers\Frontend\User;

use App\Domains\Website\Models\GeneralSetting;
// use App\Domains\Website\Models\HeroSection;

/**
 * Class DashboardController.
 */
class DashboardController
{
    /**
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function index()
    {
        // $hero = HeroSection::first();

        $setting = GeneralSetting::first();

        return view('frontend.user.dashboard', compact('hero', 'setting'));
    }
}