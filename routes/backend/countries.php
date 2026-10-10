<?php

use App\Http\Controllers\CountryController;
use App\Http\Controllers\StateController;
use App\Http\Controllers\StateManagementController;
use App\Http\Controllers\CityController;
use App\Http\Controllers\HotelController;




Route::resource('countries', CountryController::class);
Route::resource('states', StateController::class);

Route::get('/state-management', [StateManagementController::class, 'index'])
    ->name('backend.state-management.index');

Route::get('/state-management/states/{countryId}', [StateManagementController::class, 'getStates'])
    ->name('backend.state-management.states');

Route::post('/state-management/states', [StateManagementController::class, 'store'])
    ->name('backend.state-management.states.store');

Route::put('/state-management/states/{state}', [StateManagementController::class, 'update'])
    ->name('backend.state-management.states.update');

Route::delete('/state-management/states/{state}', [StateManagementController::class, 'destroy'])
    ->name('backend.state-management.states.destroy');

Route::get('cities/states/{countryId}', [CityController::class, 'getStates'])
    ->name('backend.cities.states');

Route::resource('cities', CityController::class);

//hotel_routes....
Route::resource('hotels', HotelController::class);

Route::get('hotels/states/{countryId}', [HotelController::class, 'getStates'])
    ->name('backend.hotels.states');

Route::get('hotels/cities/{stateId}', [HotelController::class, 'getCities'])
    ->name('backend.hotels.cities');