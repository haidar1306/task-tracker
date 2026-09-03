<?php

use App\Http\Controllers\Frontend\RoomController;
use App\Http\Controllers\Frontend\PaymentController;
use App\Http\Controllers\Frontend\InvoiceController;
use App\Http\Controllers\Frontend\AmenityController;
use App\Http\Controllers\Frontend\AboutController;
use App\Http\Controllers\Frontend\NewServiceController;
use App\Http\Controllers\Frontend\GalleryController;
use App\Http\Controllers\Frontend\OffersController;
use App\Http\Controllers\Frontend\HotelUpdatesController;
use App\Http\Controllers\Frontend\InquiryController;
use App\Http\Controllers\Frontend\NotificationController;


Route::post('/payment/verify', [PaymentController::class, 'verify'])
    ->withoutMiddleware(['auth'])
    ->name('payment.verify');

Route::post('/payment/create-order', [PaymentController::class, 'createOrder'])
    ->name('payment.create-order');

Route::get('/about', [AboutController::class, 'index'])->name('about');

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

Route::get('/contact', [\App\Http\Controllers\Frontend\ContactController::class, 'index'])
    ->name('contact');

Route::group(['middleware' => ['auth', 'is_user']], function () {

    //    room routes......
    Route::prefix('room')
        ->name('room.')
        ->group(function () {

            Route::get('/', [RoomController::class, 'index'])
                ->name('index');

            Route::get('/{room}', [RoomController::class, 'show'])
                ->name('show');
        });


    // payment routes.....
    Route::post('/payment/test', function () {

        return response()->json([
            'ok' => true
        ]);

    });

    Route::prefix('payment')
        ->name('payment.')
        ->group(function () {

            Route::get('/{invoice}/create', [PaymentController::class, 'create'])
                ->name('create');

            Route::post('/{invoice}', [PaymentController::class, 'store'])
                ->name('store');
            // payment verify (NO AUTH)
    
        });

    //invoice routes...

    Route::prefix('invoice')
        ->name('invoice.')
        ->group(function () {

            //          Route::get('/invoice/{invoice}', [InvoiceController::class, 'show'])
            // ->name('show');
        });

    // amenities routes....

    Route::prefix('amenities')
        ->name('amenities.')
        ->group(function () {

            Route::get('/', function () {
                return view('frontend.amenities.index');
            })->name('index');
        });


});


Route::post('/contact', [InquiryController::class, 'store'])
    ->name('frontend.inquiry.store');
    
Route::get(
    'my-inquiries/{inquiry}',
    [InquiryController::class, 'show']
)->name('frontend.inquiries.show');

Route::get('notifications/{id}/read', [NotificationController::class, 'read'])
    ->name('frontend.notifications.read')
    ->middleware('auth');

    Route::get(
    '/notifications',
    [NotificationController::class, 'index']
)->name('frontend.notifications.index');

