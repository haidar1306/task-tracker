<?php

use App\Http\Controllers\Backend\AmenityController;
use Tabuna\Breadcrumbs\Trail;

Route::group([
    'prefix' => 'amenities',
    'as' => 'amenities.',
], function () {

    Route::get('/', [AmenityController::class, 'index'])
        ->name('index')
        ->breadcrumbs(function (Trail $trail) {
            $trail->parent('admin.dashboard')
                ->push('Amenities');
        });

    Route::get('/create', [AmenityController::class, 'create'])
        ->name('create');

    Route::post('/', [AmenityController::class, 'store'])
        ->name('store');

    Route::get('/{amenity}/edit', [AmenityController::class, 'edit'])
        ->name('edit');

    Route::put('/{amenity}', [AmenityController::class, 'update'])
        ->name('update');

    Route::delete('/{amenity}', [AmenityController::class, 'destroy'])
        ->name('destroy');

});