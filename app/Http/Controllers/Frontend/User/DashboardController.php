<?php

namespace App\Http\Controllers\Frontend\User;

use App\Models\RoomType;

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
        $featuredRoomTypes = RoomType::where('status', 1)
            ->latest()
            ->take(3)
            ->get();

        return view('frontend.user.dashboard', compact('featuredRoomTypes'));
    }
}