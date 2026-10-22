<?php

use App\Http\Controllers\Backend\BookingController;
use App\Http\Controllers\Backend\ExternalBookingController;
use Tabuna\Breadcrumbs\Trail;

Route::group([
    'prefix' => 'bookings',
    'as' => 'bookings.',
], function () {

    /*
    |--------------------------------------------------------------------------
    | Local Bookings
    |--------------------------------------------------------------------------
    */

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


    /*
    |--------------------------------------------------------------------------
    | External / Dubai Bookings
    |--------------------------------------------------------------------------
    */

    Route::group([
        'prefix' => 'external-bookings',
        'as' => 'external-bookings.',
    ], function () {

        Route::get('/', [ExternalBookingController::class, 'index'])
            ->name('index');

        Route::get('/{externalBooking}', [ExternalBookingController::class, 'show'])
            ->name('show');

        Route::post('/{externalBooking}/confirm', [ExternalBookingController::class, 'confirm'])
            ->name('confirm');

        Route::post('/{externalBooking}/check-in', [ExternalBookingController::class, 'checkIn'])
            ->name('checkIn');

        Route::post('/{externalBooking}/check-out', [ExternalBookingController::class, 'checkOut'])
            ->name('checkOut');
    });


    /*
    |--------------------------------------------------------------------------
    | Local Booking Details
    |--------------------------------------------------------------------------
    */

    Route::get('/{booking}', [BookingController::class, 'show'])
        ->name('show');

    Route::get('/{booking}/edit', [BookingController::class, 'edit'])
        ->name('edit')
        ->breadcrumbs(function (Trail $trail, $booking) {
            $trail->parent('admin.bookings.index')
                ->push(
                    'Edit Booking',
                    route('admin.bookings.edit', $booking)
                );
        });

    Route::put('/{booking}', [BookingController::class, 'update'])
        ->name('update');

    Route::delete('/{booking}', [BookingController::class, 'destroy'])
        ->name('destroy');
    Route::post('/{booking}/confirm', [BookingController::class, 'confirm'])->name('confirm');
    Route::post('/{booking}/reject', [BookingController::class, 'reject'])->name('reject');
    Route::post('/{booking}/cancel', [BookingController::class, 'cancel'])->name('cancel');
    Route::post('/{booking}/no-show', [BookingController::class, 'noShow'])->name('noShow');
    Route::post('/{booking}/check-in', [BookingController::class, 'checkIn'])
        ->name('checkIn');

    Route::post('/{booking}/check-out', [BookingController::class, 'checkOut'])
        ->name('checkOut');

});