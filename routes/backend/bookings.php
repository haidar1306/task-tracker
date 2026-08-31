<?php

use App\Http\Controllers\Backend\BookingController;
use Tabuna\Breadcrumbs\Trail;

Route::group([
    'prefix' => 'bookings',
    'as' => 'bookings.',
], function () {

    Route::get('/', [BookingController::class, 'index'])
        ->name('index')
        ->breadcrumbs(function (Trail $trail) {
            $trail->parent('admin.dashboard')
                ->push('Bookings', route('admin.bookings.index'));
        });

    Route::get('/create', [BookingController::class, 'create'])
        ->name('create')
        ->breadcrumbs(function (Trail $trail) {
            $trail->parent('admin.bookings.index')
                ->push('Create Booking', route('admin.bookings.create'));
        });

    Route::post('/', [BookingController::class, 'store'])
        ->name('store');

    Route::get('/check-in', [BookingController::class, 'checkInIndex'])
        ->name('checkInIndex');

    Route::get('/check-out', [BookingController::class, 'checkOutIndex'])
        ->name('checkOutIndex');

    Route::get('/{booking}', [BookingController::class, 'show'])
        ->name('show');

    Route::get('/{booking}/edit', [BookingController::class, 'edit'])
        ->name('edit')
        ->breadcrumbs(function (Trail $trail, $booking) {
            $trail->parent('admin.bookings.index')
                ->push('Edit Booking', route('admin.bookings.edit', $booking));
        });

    Route::put('/{booking}', [BookingController::class, 'update'])
        ->name('update');

    Route::delete('/{booking}', [BookingController::class, 'destroy'])
        ->name('destroy');

    Route::get('/{booking}/confirm', [BookingController::class, 'confirm'])
        ->name('confirm');

    Route::get('/{booking}/cancel', [BookingController::class, 'cancel'])
        ->name('cancel');

    Route::post('/{booking}/check-in', [BookingController::class, 'checkIn'])
        ->name('checkIn');

    Route::post('/{booking}/check-out', [BookingController::class, 'checkOut'])
        ->name('checkOut');

});