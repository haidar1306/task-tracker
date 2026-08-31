<?php

use App\Http\Controllers\Frontend\BookingsController;

Route::group(['middleware' => ['auth']], function () {
    
//booking route...

    Route::prefix('bookings')
        ->name('bookings.')
        ->group(function () {

            // Create Booking
            Route::get('/create/{room}', [BookingsController::class, 'create'])
                ->name('create');

            // Store Booking
            Route::post('/store', [BookingsController::class, 'store'])
                ->name('store');

            // Show Booking
            Route::get('/{booking}', [BookingsController::class, 'show'])
                ->name('show');

            // Cancel Booking
            Route::post('/{booking}/cancel', [BookingsController::class, 'cancel'])
                ->name('cancel');

        });

});