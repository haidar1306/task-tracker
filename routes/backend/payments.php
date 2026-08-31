<?php

use App\Http\Controllers\Backend\PaymentController;
use Tabuna\Breadcrumbs\Trail;

Route::group([
    'prefix' => 'payments',
    'as' => 'payments.',
], function () {

    Route::get('/', [PaymentController::class, 'index'])
        ->name('index')
        ->breadcrumbs(function (Trail $trail) {
            $trail->parent('admin.dashboard')
                ->push('Payments', route('admin.payments.index'));
        });

    Route::get('/create', [PaymentController::class, 'create'])
        ->name('create')
        ->breadcrumbs(function (Trail $trail) {
            $trail->parent('admin.payments.index')
                ->push('Create Payment', route('admin.payments.create'));
        });

    Route::post('/', [PaymentController::class, 'store'])
        ->name('store');

    Route::get('/{payment}/edit', [PaymentController::class, 'edit'])
        ->name('edit')
        ->breadcrumbs(function (Trail $trail, $payment) {
            $trail->parent('admin.payments.index')
                ->push('Edit Payment', route('admin.payments.edit', $payment));
        });

    Route::put('/{payment}', [PaymentController::class, 'update'])
        ->name('update');

    Route::delete('/{payment}', [PaymentController::class, 'destroy'])
        ->name('destroy');

   
});
