<?php

use App\Http\Controllers\Backend\InvoiceController;
use Illuminate\Support\Facades\Route;

Route::group([
    'prefix' => 'invoices',
    'as' => 'invoices.',
], function () {

    Route::get('/', [InvoiceController::class, 'index'])
        ->name('index')
        ->breadcrumbs(function ($trail) {
            $trail->parent('admin.dashboard')
                  ->push('Invoices', route('admin.invoices.index'));
        });

    Route::get('/create', [InvoiceController::class, 'create'])
        ->name('create')
        ->breadcrumbs(function ($trail) {
            $trail->parent('admin.invoices.index')
                  ->push('Create Invoice', route('admin.invoices.create'));
        });

    Route::post('/', [InvoiceController::class, 'store'])
        ->name('store');

    Route::get('/{invoice}', [InvoiceController::class, 'show'])
        ->name('show')
        ->breadcrumbs(function ($trail, $invoice) {
            $trail->parent('admin.invoices.index')
                  ->push('Invoice Details', route('admin.invoices.show', $invoice));
        });

    Route::delete('/{invoice}', [InvoiceController::class, 'destroy'])
        ->name('destroy');

});