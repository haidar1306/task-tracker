<?php

use App\Http\Controllers\Frontend\CouponController;
use Illuminate\Support\Facades\Route;

Route::post('/coupon/apply', [CouponController::class, 'apply'])
    ->name('coupon.apply');