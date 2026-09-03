<?php

use App\Http\Controllers\Frontend\ReservationController;

Route::group(['middleware' => ['auth', 'is_user']], function () {

  // Reservation Routes
  
    Route::prefix('reservations')
        ->name('reservation.')
        ->group(function () {

            // Reservation List
            Route::get('/', [ReservationController::class, 'index'])
                ->name('index');

            // Show Reservation
            Route::get('/{reservation}', [ReservationController::class, 'show'])
                ->name('show');

        });

});