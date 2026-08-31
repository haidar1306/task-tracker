<?php
use App\Http\Controllers\Backend\InquiryController;

Route::resource('inquiries', InquiryController::class)
    ->only(['index', 'show', 'destroy']);
    
Route::post(
    'inquiries/{inquiry}/reply',
    [InquiryController::class,'storeReply']
)->name('admin.inquiries.reply.store');