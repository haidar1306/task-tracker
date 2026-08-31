<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\RoomType;
use App\Services\RoomTypeService;
use App\Http\Requests\StoreRoomTypeRequest;
use App\Http\Requests\UpdateRoomTypeRequest;

class RoomTypeController extends Controller
{
    protected $service;

    public function __construct(RoomTypeService $service)
    {
        $this->service = $service;
    }

    public function index()
{
     $roomTypes = $this->service->all(5, request('search'));

         return view('backend.room-type.index', compact('roomTypes'));

}

    public function create()
    {
        return view('backend.room-type.create');
    }

    public function store(StoreRoomTypeRequest $request)
    {
        $this->service->store($request->validated());

        return redirect()
            ->route('admin.room-types.index')
            ->withFlashSuccess('Room Type Created Successfully.');
    }

    public function edit(RoomType $roomType)
    {
        return view('backend.room-type.edit', compact('roomType'));
    }

    public function update(UpdateRoomTypeRequest $request, RoomType $roomType)
    {
        $this->service->update($roomType, $request->validated());

        return redirect()
            ->route('admin.room-types.index')
            ->withFlashSuccess('Room Type Updated Successfully.');
    }

    public function destroy(RoomType $roomType)
    {
        $this->service->delete($roomType);

        return redirect()
            ->route('admin.room-types.index')
            ->withFlashSuccess('Room Type Deleted Successfully.');
    }
}