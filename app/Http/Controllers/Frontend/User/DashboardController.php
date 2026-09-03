<?php

namespace App\Http\Controllers\Frontend\User;

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

        

        return view('frontend.user.dashboard', compact('hero', 'setting'));
    }
}