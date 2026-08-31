<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreBedTypeRequest;
use App\Http\Requests\UpdateBedTypeRequest;
use App\Models\BedType;
use App\Services\BedTypeService;

class BedTypeController extends Controller
{
    protected $service;

    public function __construct(BedTypeService $service)
    {
        $this->service = $service;
    }

    public function index()
    {
        $bedTypes = $this->service->all(1, request('search'));

        return view('backend.bed-types.index', compact('bedTypes'));
    }

    public function create()
    {
        return view('backend.bed-types.create');
    }

    public function store(StoreBedTypeRequest $request)
    {
        $this->service->store($request->validated());

        return redirect()
            ->route('admin.bed-types.index')
            ->withFlashSuccess('Bed Type Created Successfully.');
    }

    public function edit(BedType $bedType)
    {
        return view('backend.bed-types.edit', compact('bedType'));
    }

    public function update(UpdateBedTypeRequest $request, BedType $bedType)
    {
        $this->service->update($bedType, $request->validated());

        return redirect()
            ->route('admin.bed-types.index')
            ->withFlashSuccess('Bed Type Updated Successfully.');
    }

    public function destroy(BedType $bedType)
    {
        $this->service->delete($bedType);

        return redirect()
            ->route('admin.bed-types.index')
            ->withFlashSuccess('Bed Type Deleted Successfully.');
    }
}