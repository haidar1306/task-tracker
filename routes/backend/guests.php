<?php

use App\Http\Controllers\Backend\GuestController;
use Tabuna\Breadcrumbs\Trail;

Route::group([
    'prefix' => 'guests',
    'as' => 'guests.',
], function () {

    Route::get('/', [GuestController::class, 'index'])
        ->name('index')
        ->breadcrumbs(function (Trail $trail) {
            $trail->parent('admin.dashboard')
                ->push('Guests', route('admin.guests.index'));
        });

    Route::get('/create', [GuestController::class, 'create'])
        ->name('create')
        ->breadcrumbs(function (Trail $trail) {
            $trail->parent('admin.guests.index')
                ->push('Create Guest', route('admin.guests.create'));
        });

    Route::post('/', [GuestController::class, 'store'])->name('store');

    Route::get('/{guest}/edit', [GuestController::class, 'edit'])
        ->name('edit')
        ->breadcrumbs(function (Trail $trail, $guest) {
            $trail->parent('admin.guests.index')
                ->push('Edit Guest', route('admin.guests.edit', $guest));
        });

    Route::put('/{guest}', [GuestController::class, 'update'])->name('update');
        
    Route::delete('/{guest}', [GuestController::class, 'destroy']) ->name('destroy');
       

});