<?php

use App\Http\Controllers\Backend\CouponController;
use Illuminate\Support\Facades\Route;

Route::group([
    'prefix' => 'coupons',
    'as' => 'coupons.',
], function () {

    Route::get('/', [CouponController::class, 'index'])
        ->name('index');

    Route::get('/create', [CouponController::class, 'create'])
        ->name('create');

    Route::post('/', [CouponController::class, 'store'])
        ->name('store');

    Route::get('/{coupon}/edit', [CouponController::class, 'edit'])
        ->name('edit');

    Route::put('/{coupon}', [CouponController::class, 'update'])
        ->name('update');

    Route::delete('/{coupon}', [CouponController::class, 'destroy'])
        ->name('destroy');
});
