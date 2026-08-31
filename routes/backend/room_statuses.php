<?php

use App\Http\Controllers\Backend\RoomStatusController;
use Tabuna\Breadcrumbs\Trail;

Route::group([
    'prefix' => 'room-statuses',
    'as' => 'room-statuses.',
], function () {

    Route::get('/', [RoomStatusController::class, 'index'])
        ->name('index')
        ->breadcrumbs(function (Trail $trail) {
            $trail->parent('admin.dashboard')
                  ->push('Room Statuses');
        });

    Route::get('/create', [RoomStatusController::class, 'create'])
        ->name('create');

    Route::post('/', [RoomStatusController::class, 'store'])
        ->name('store');

    Route::get('/{roomStatus}/edit', [RoomStatusController::class, 'edit'])
        ->name('edit');

    Route::put('/{roomStatus}', [RoomStatusController::class, 'update'])
        ->name('update');

    Route::delete('/{roomStatus}', [RoomStatusController::class, 'destroy'])
        ->name('destroy');
});