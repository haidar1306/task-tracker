<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreRoomStatusRequest;
use App\Http\Requests\UpdateRoomStatusRequest;
use App\Models\RoomStatus;
use App\Services\RoomStatusService;

class RoomStatusController extends Controller
{
    protected $service;

    public function __construct(RoomStatusService $service)
    {
        $this->service = $service;
    }

    public function index()
    {
        $roomStatuses = $this->service->all(5, request('search'));

        return view('backend.room-statuses.index', compact('roomStatuses'));
    }

    public function create()
    {
        return view('backend.room-statuses.create');
    }

    public function store(StoreRoomStatusRequest $request)
    {
        $this->service->store($request->validated());

        return redirect()
            ->route('admin.room-statuses.index')
            ->withFlashSuccess('Room Status Created Successfully.');
    }

    public function edit(RoomStatus $roomStatus)
    {
        return view('backend.room-statuses.edit', compact('roomStatus'));
    }

    public function update(UpdateRoomStatusRequest $request, RoomStatus $roomStatus)
    {
        $this->service->update($roomStatus, $request->validated());

        return redirect()
            ->route('admin.room-statuses.index')
            ->withFlashSuccess('Room Status Updated Successfully.');
    }

    public function destroy(RoomStatus $roomStatus)
    {
        $this->service->delete($roomStatus);

        return redirect()
            ->route('admin.room-statuses.index')
            ->withFlashSuccess('Room Status Deleted Successfully.');
    }
}