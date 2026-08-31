<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreAmenityRequest;
use App\Http\Requests\UpdateAmenityRequest;
use App\Models\Amenity;
use App\Services\AmenityService;

class AmenityController extends Controller
{
    protected $service;

    public function __construct(AmenityService $service)
    {
        $this->service = $service;
    }

    public function index()
    {
        $amenities = $this->service->all(3, request('search'));

        return view('backend.amenities.index', compact('amenities'));
    }

    public function create()
    {
        return view('backend.amenities.create');
    }

    public function store(StoreAmenityRequest $request)
    {
        $this->service->store($request->validated());

        return redirect()
            ->route('admin.amenities.index')
            ->withFlashSuccess('Amenity Created Successfully.');
    }

    public function edit(Amenity $amenity)
    {
        return view('backend.amenities.edit', compact('amenity'));
    }

    public function update(UpdateAmenityRequest $request, Amenity $amenity)
    {
        $this->service->update($amenity, $request->validated());

        return redirect()
            ->route('admin.amenities.index')
            ->withFlashSuccess('Amenity Updated Successfully.');
    }

    public function destroy(Amenity $amenity)
    {
        $this->service->delete($amenity);

        return redirect()
            ->route('admin.amenities.index')
            ->withFlashSuccess('Amenity Deleted Successfully.');
    }
}