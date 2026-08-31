<?php

namespace App\Domains\Website\Services;

use App\Domains\Website\Models\HeroSection;
use Illuminate\Support\Facades\DB;

class HeroSectionService
{
    /**
     * Get Hero Section
     */
    public function getHero()
    {
        return HeroSection::first();
    }

    /**
     * Update Hero Section
     */
    public function updateHero(HeroSection $heroSection, array $data)
    {
        return DB::transaction(function () use ($heroSection, $data) {

            $heroSection->update($data);

            return $heroSection;
        });
    }
}