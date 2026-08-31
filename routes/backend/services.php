<?php
use App\Http\Controllers\Backend\ServiceController;



Route::get('services', [ServiceController::class, 'index'])->name('services.index');

Route::get('services/create', [ServiceController::class, 'create'])->name('services.create');

Route::post('services/store', [ServiceController::class, 'store'])->name('services.store');

Route::get('services/{service}/edit', [ServiceController::class, 'edit'])->name('services.edit');

Route::put('services/{service}', [ServiceController::class, 'update'])->name('services.update');

Route::delete('services/{service}', [ServiceController::class, 'destroy'])->name('services.destroy');


