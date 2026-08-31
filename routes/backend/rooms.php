<?php

use App\Http\Controllers\Backend\RoomController;
use Tabuna\Breadcrumbs\Trail;

Route::group([
    'prefix' => 'rooms',
    'as' => 'rooms.',
], function () {

    Route::get('/', [RoomController::class, 'index'])
        ->name('index')
        ->breadcrumbs(function (Trail $trail) {
            $trail->parent('admin.dashboard')
                ->push('Rooms');
        });

    Route::get('/create', [RoomController::class, 'create'])
        ->name('create');

    Route::post('/', [RoomController::class, 'store'])
        ->name('store');

    Route::get('/{room}/edit', [RoomController::class, 'edit'])
        ->name('edit');

    Route::put('/{room}', [RoomController::class, 'update'])
        ->name('update');

    Route::delete('/{room}', [RoomController::class, 'destroy'])
        ->name('destroy');
});