<?php

use App\Http\Controllers\Backend\BedTypeController;
use Tabuna\Breadcrumbs\Trail;

Route::group([
    'prefix' => 'bed-types',
    'as' => 'bed-types.',
], function () {

    Route::get('/', [BedTypeController::class, 'index'])
        ->name('index')
        ->breadcrumbs(function (Trail $trail) {
            $trail->parent('admin.dashboard')
                ->push('Bed Types');
        });

    Route::get('/create', [BedTypeController::class, 'create'])
        ->name('create');

    Route::post('/', [BedTypeController::class, 'store'])
        ->name('store');

    Route::get('/{bedType}/edit', [BedTypeController::class, 'edit'])
        ->name('edit');

    Route::put('/{bedType}', [BedTypeController::class, 'update'])
        ->name('update');

    Route::delete('/{bedType}', [BedTypeController::class, 'destroy'])
        ->name('destroy');

});