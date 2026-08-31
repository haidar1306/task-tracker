<?php

use App\Http\Controllers\Backend\DashboardController;
use Tabuna\Breadcrumbs\Trail;

// All route names are prefixed with 'admin.'.
Route::redirect('/', '/admin/dashboard', 301);
Route::get('dashboard', [DashboardController::class, 'index'])
    ->name('dashboard')
    ->breadcrumbs(function (Trail $trail) {
        $trail->push(__('Home'), route('admin.dashboard'));
    });
require __DIR__.'/room_types.php';
require __DIR__.'/rooms.php';
require __DIR__.'/amenities.php';
require __DIR__.'/bed_types.php';
require __DIR__.'/floors.php';
require __DIR__.'/room_statuses.php';   
require __DIR__.'/bookings.php';
require __DIR__.'/guests.php';
require __DIR__.'/payments.php';
require __DIR__.'/website.php';