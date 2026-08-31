<?php

namespace App\Domains\Website\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Domains\Website\Models\GeneralSetting;
use App\Domains\Website\Requests\UpdateGeneralSettingRequest;
use App\Domains\Website\Services\GeneralSettingService;
use Illuminate\Support\Facades\Storage;

class GeneralSettingController extends Controller
{
    /**
     * General Setting Service
     *
     * @var GeneralSettingService
     */
    protected $generalSettingService;

    /**
     * Constructor
     */
    public function __construct(GeneralSettingService $generalSettingService)
    {
        $this->generalSettingService = $generalSettingService;
    }

    /**
     * Show General Settings Form
     */
    public function edit()
    {
        $setting = $this->generalSettingService->getSettings();

        return view('backend.website.hero.general.edit', compact('setting'));
    }

    /**
     * Update General Settings
     */
    public function update(UpdateGeneralSettingRequest $request)
    {
        $setting = $this->generalSettingService->getSettings();

        $data = $request->validated();

        /*
        |--------------------------------------------------------------------------
        | Website Logo Upload
        |--------------------------------------------------------------------------
        */
        if ($request->hasFile('website_logo')) {

            if ($setting && $setting->website_logo &&
                Storage::disk('public')->exists($setting->website_logo)) {

                Storage::disk('public')->delete($setting->website_logo);
            }

            $data['website_logo'] = $request
                ->file('website_logo')
                ->store('website/logo', 'public');
        }

        /*
        |--------------------------------------------------------------------------
        | Favicon Upload
        |--------------------------------------------------------------------------
        */
        if ($request->hasFile('favicon')) {

            if ($setting && $setting->favicon &&
                Storage::disk('public')->exists($setting->favicon)) {

                Storage::disk('public')->delete($setting->favicon);
            }

            $data['favicon'] = $request
                ->file('favicon')
                ->store('website/favicon', 'public');
        }

        /*
        |--------------------------------------------------------------------------
        | Save Data
        |--------------------------------------------------------------------------
        */
        if ($setting) {

            $this->generalSettingService->updateSettings($setting, $data);

        } else {

            GeneralSetting::create($data);
        }

        return redirect()
            ->back()
            ->withFlashSuccess('General Settings updated successfully.');
    }
}