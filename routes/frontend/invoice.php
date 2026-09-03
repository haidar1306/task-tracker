<?php

use App\Http\Controllers\Frontend\InvoiceController;

Route::group(['middleware' => ['auth', 'is_user']], function () {

   //invoice routes..
   
    Route::prefix('invoice')
        ->name('invoice.')
        ->group(function () {

            // Show Invoice
            Route::get('/{invoice}', [InvoiceController::class, 'show'])
                ->name('show');

        });

});