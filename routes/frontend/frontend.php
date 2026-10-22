<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Frontend\RoomController;
use App\Http\Controllers\Frontend\PaymentController;
use App\Http\Controllers\Frontend\AboutController;
use App\Http\Controllers\Frontend\NewServiceController;
use App\Http\Controllers\Frontend\GalleryController;
use App\Http\Controllers\Frontend\OffersController;
use App\Http\Controllers\Frontend\HotelUpdatesController;
use App\Http\Controllers\Frontend\InquiryController;
use App\Http\Controllers\Frontend\NotificationController;
use App\Http\Controllers\Frontend\InvoiceController;
use App\Http\Controllers\Frontend\AmenityController;

// Payment verification
Route::post('/payment/verify', [PaymentController::class, 'verify'])
    ->withoutMiddleware(['auth'])
    ->name('payment.verify');

// Payment order creation
Route::post('/payment/create-order', [PaymentController::class, 'createOrder'])
    ->middleware(['auth', 'is_user'])
    ->name('payment.create-order');

// Public pages
Route::get('/about', [AboutController::class, 'index'])
    ->name('about');

Route::get('/services', [NewServiceController::class, 'index'])
    ->name('services');

Route::get('/services/{service}', [NewServiceController::class, 'show'])
    ->name('services.show');

Route::get('/gallery', [GalleryController::class, 'index'])
    ->name('gallery');

Route::get('/offers', [OffersController::class, 'index'])
    ->name('offers');

Route::get('/hotel-updates', [HotelUpdatesController::class, 'index'])
    ->name('hotel-updates');
// Public: page sabko dikhega
Route::get('/contact', [
    \App\Http\Controllers\Frontend\ContactController::class,
    'index'
])->name('contact');

// Submit: sirf logged-in user
Route::post('/contact', [InquiryController::class, 'store'])
    ->middleware(['auth', 'throttle:5,1'])
    ->name('frontend.inquiry.store');
Route::get('/my-inquiries/{inquiry}', [
    InquiryController::class,
    'show'
])->name('frontend.inquiries.show');
Route::middleware('auth')->group(function () {
    // List page (?inquiry=8 se drawer apne aap khulta hai)
    Route::get('/my-inquiries', [InquiryController::class, 'index'])
        ->name('frontend.inquiries.index');
 
    // Ajax detail (JSON). Path alag rakha hai ('/detail') taaki purane
    // '/my-inquiries/{inquiry}' se clash na ho.
    Route::get('/my-inquiries/{id}/detail', [InquiryController::class, 'detail'])
        ->whereNumber('id')
        ->name('frontend.inquiries.detail');
});

// Local booking payment and invoice routes
Route::middleware(['auth', 'is_user'])->group(function () {

    Route::prefix('payment')->name('payment.')->group(function () {
        Route::get('/{invoice}/create', [
            PaymentController::class,
            'create'
        ])->name('create');

        Route::post('/{invoice}', [
            PaymentController::class,
            'store'
        ])->name('store');
    });

    Route::prefix('invoice')->name('invoice.')->group(function () {
        // Add your existing local invoice routes here if required.
    });

   Route::get('/amenities', [AmenityController::class, 'index'])
    ->name('amenities.index');
    
});

// Notifications
Route::get('/notifications/{id}/read', [
    NotificationController::class,
    'read'
])->name('frontend.notifications.read')
    ->middleware('auth');

Route::get('/notifications', [
    NotificationController::class,
    'index'
])->name('frontend.notifications.index');

// Local database rooms
Route::prefix('room')->name('room.')->group(function () {
    Route::get('/', [RoomController::class, 'indexLocal'])
        ->name('index');

    Route::get('/{room}', [RoomController::class, 'show'])
        ->name('show');
});
