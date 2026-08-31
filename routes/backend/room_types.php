<?php

use App\Http\Controllers\Backend\RoomTypeController;
use Tabuna\Breadcrumbs\Trail;

Route::group([
    'prefix' => 'room-types',
    'as' => 'room-types.',
], function () {

    Route::get('/', [RoomTypeController::class, 'index'])
        ->name('index')
        ->breadcrumbs(function (Trail $trail) {
            $trail->parent('admin.dashboard')
                ->push('Room Types');
        });

    Route::get('/create', [RoomTypeController::class, 'create'])
        ->name('create');

    Route::post('/', [RoomTypeController::class, 'store'])
        ->name('store');

    Route::get('/{roomType}/edit', [RoomTypeController::class, 'edit'])
        ->name('edit');

    Route::put('/{roomType}', [RoomTypeController::class, 'update'])
        ->name('update');

    Route::delete('/{roomType}', [RoomTypeController::class, 'destroy'])
        ->name('destroy');
});