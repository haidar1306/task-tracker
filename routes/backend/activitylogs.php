<?php
use App\Http\Controllers\Backend\ActivityLogController;

Route::get('activity-logs', [ActivityLogController::class, 'index'])
    ->name('admin.activity-logs.index');

    Route::get(
    'activity-logs/search',
    [ActivityLogController::class,'search']
)->name('admin.activity-logs.search');