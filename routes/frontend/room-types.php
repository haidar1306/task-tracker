<?php

use App\Http\Controllers\Frontend\RoomTypeController;

Route::group(['middleware' => ['auth']], function () {

   //Room Type Routes
   
    Route::prefix('room-types')
        ->name('room-types.')
        ->group(function () {

            // Room Type List
            Route::get('/', [RoomTypeController::class, 'index'])
                ->name('index');

        });

});