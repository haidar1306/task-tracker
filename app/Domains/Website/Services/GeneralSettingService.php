<?php

namespace App\Domains\Website\Services;

use App\Domains\Website\Models\GeneralSetting;
use Illuminate\Support\Facades\DB;

class GeneralSettingService
{
    /**
     * Get General Settings
     */
    public function getSettings()
    {
        return GeneralSetting::first();
    }

    /**
     * Create General Settings
     */
    public function create(array $data)
    {
        return DB::transaction(function () use ($data) {
            return GeneralSetting::create($data);
        });
    }

    /**
     * Update General Settings
     */
    public function updateSettings(GeneralSetting $setting, array $data)
    {
        return DB::transaction(function () use ($setting, $data) {
            $setting->update($data);

            return $setting;
        });
    }
}