<?php

use App\Http\Controllers\Backend\NotificationController;
use Illuminate\Support\Facades\Route;

Route::group([
    'prefix' => 'notifications',
    'as' => 'notifications.',
], function () {

    Route::get('/{id}/read', [NotificationController::class, 'read'])
        ->name('read');

    Route::delete('/{id}', [NotificationController::class, 'destroy'])
        ->name('destroy');

});