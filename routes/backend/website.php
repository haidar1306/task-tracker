<?php
use App\Domains\Website\Http\Controllers\Backend\GeneralSettingController;

use App\Domains\Website\Http\Controllers\Backend\HeroSectionController;
use Tabuna\Breadcrumbs\Trail;

Route::group([
    'prefix' => 'website',
    'as' => 'website.',
], function () {

    Route::get('/hero', [HeroSectionController::class, 'edit'])
        ->name('hero.edit')
        ->breadcrumbs(function (Trail $trail) {
            $trail->parent('admin.dashboard')
                ->push('Website Management')                    
                ->push('Hero Section');
        });

    Route::put('/hero', [HeroSectionController::class, 'update'])
        ->name('hero.update');
        
           /*
    |--------------------------------------------------------------------------
    | General Settings
    |--------------------------------------------------------------------------
    */
    Route::get('general-settings', [GeneralSettingController::class, 'edit'])
        ->name('general.edit');

    Route::put('general-settings', [GeneralSettingController::class, 'update'])
        ->name('general.update');

        

});