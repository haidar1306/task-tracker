<?php
use App\Domains\Auth\Http\Middleware\UserCheck;

use App\Http\Controllers\Frontend\HomeController;
use App\Http\Controllers\Frontend\TermsController;
use Tabuna\Breadcrumbs\Trail;
use App\Models\Room;
/*
 * Frontend Controllers
 * All route names are prefixed with 'frontend.'.
 */
Route::get('/', [HomeController::class, 'index'])
    ->name('index')
    ->breadcrumbs(function (Trail $trail) {
        $trail->push(__('Home'), route('frontend.index'));
    });

/*
 * Normal authenticated user dashboard.
 * No AdminCheck or SuperAdminCheck middleware here.
 */


Route::get('hotel/dashboard', function () {
    $rooms = Room::query()
        ->bookable()
        ->with(['roomType', 'amenities'])
        ->orderBy('room_type_id')
        ->orderBy('room_number')
        ->take(8)
        ->get();

    $rooms = \App\Models\Room::with(['roomType', 'amenities'])
        ->whereHas('roomType')
        ->orderBy('room_type_id')
        ->orderBy('room_number')
        ->get();

    return view('frontend.user.dashboard', compact('rooms'));

})
    ->middleware(['auth', UserCheck::class])
    ->name('hotel.dashboard')
    ->breadcrumbs(function (Trail $trail) {
        $trail->parent('frontend.index')
            ->push(__('Dashboard'), route('frontend.hotel.dashboard'));
    });
Route::get('terms', [TermsController::class, 'index'])
    ->name('pages.terms')
    ->breadcrumbs(function (Trail $trail) {
        $trail->parent('frontend.index')
            ->push(__('Terms & Conditions'), route('frontend.pages.terms'));
    });

