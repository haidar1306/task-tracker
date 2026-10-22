<?php

use App\Http\Controllers\Frontend\CouponController;
use Illuminate\Support\Facades\Route;

Route::post('/coupon/apply', [CouponController::class, 'apply'])
    ->middleware(['auth', 'is_user', 'throttle:30,1'])
    ->name('coupon.apply');