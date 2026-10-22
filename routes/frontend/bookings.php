<?php
use App\Http\Controllers\Frontend\BookingsController;


Route::middleware(['auth', 'is_user'])->group(function () {
    Route::get('bookings/create/{room}', [BookingsController::class, 'create'])->name('bookings.create');
    Route::post('bookings', [BookingsController::class, 'store'])
        ->middleware('throttle:10,1')
        ->name('bookings.store');
    Route::get('bookings/{booking}', [BookingsController::class, 'show'])->name('bookings.show');
    Route::get('bookings', [BookingsController::class, 'index'])->name('bookings.index');
    Route::post('bookings/{booking}/cancel', [BookingsController::class, 'cancel'])->name('bookings.cancel');
});

// Calendar ke liye (public, sirf dates deta hai)
Route::get('rooms/{room}/booked-dates', [BookingsController::class, 'bookedDates'])
    ->name('rooms.booked-dates');