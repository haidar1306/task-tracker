<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\RoomApiController;
use App\Http\Controllers\Api\AuthApiController;
use App\Http\Controllers\Api\V1\RoomSearchController;



Route::get('/test', function () {
    return response()->json([
        'message' => 'API Working'
    ]);
});

Route::get('/rooms', [RoomApiController::class, 'index']);
Route::get('/rooms/{room}', [RoomApiController::class, 'show']);
Route::post('/rooms', [RoomApiController::class, 'store']);
Route::put('/rooms/{room}', [RoomApiController::class, 'update']);
Route::delete('/rooms/{room}', [RoomApiController::class, 'destroy']);


//registered user....
Route::post('/register', [AuthApiController::class, 'register']);
Route::get('/users', [AuthApiController::class, 'users']);
Route::get('/users/{user}', [AuthApiController::class, 'show']);


Route::get('/v1/rooms/search', RoomSearchController::class);
