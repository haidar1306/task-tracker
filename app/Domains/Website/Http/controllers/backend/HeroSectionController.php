<?php

namespace App\Domains\Website\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Domains\Website\Models\HeroSection;
use App\Domains\Website\Requests\UpdateHeroSectionRequest;
use App\Domains\Website\Services\HeroSectionService;
use Illuminate\Support\Facades\Storage;

class HeroSectionController extends Controller
{
    protected $heroService;

    public function __construct(HeroSectionService $heroService)
    {
        $this->heroService = $heroService;
    }

    /**
     * Show Hero Section Form
     */
    public function edit()
    {
        $hero = $this->heroService->getHero();

        return view('backend.website.hero.edit', compact('hero'));
    }
    /**
     * Update Hero Section
     */
    public function update(UpdateHeroSectionRequest $request)
    {
        $hero = $this->heroService->getHero();

        $data = $request->validated();

        if ($request->hasFile('hero_image')) {

            if ($hero && $hero->hero_image && Storage::disk('public')->exists($hero->hero_image)) {
                Storage::disk('public')->delete($hero->hero_image);
            }

            $data['hero_image'] = $request->file('hero_image')->store('hero', 'public');
        }
        if ($request->hasFile('background_image')) {

            if (
                $hero && $hero->background_image &&
                Storage::disk('public')->exists($hero->background_image)
            ) {

                Storage::disk('public')->delete($hero->background_image);
            }

            $data['background_image'] = $request
                ->file('background_image')
                ->store('hero', 'public');
        }

        if ($hero) {
            $this->heroService->updateHero($hero, $data);
        } else {
            HeroSection::create($data);
        }

        return redirect()
            ->back()
            ->withFlashSuccess('Hero Section updated successfully.');
    }
}