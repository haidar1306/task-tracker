<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreRoomRequest;
use App\Http\Requests\UpdateRoomRequest;
use App\Models\Room;
use App\Models\RoomType;
use App\Services\RoomService;

class RoomController extends Controller
{
    protected $service;

    public function __construct(RoomService $service)
    {
        $this->service = $service;
    }

    public function index()
    {
        $rooms = $this->service->all(5, request('search'));

        return view('backend.rooms.index', compact('rooms'));
    }

    public function create()
    {
        $roomTypes = RoomType::all();
        $amenities = \App\Models\Amenity::where('status',1)->get();

        return view(
            'backend.rooms.create',
            compact('roomTypes','amenities')
        );
    }

    public function store(StoreRoomRequest $request)
    {
        $this->service->store($request->validated());

        return redirect()
            ->route('admin.rooms.index')
            ->withFlashSuccess('Room Created Successfully.');
    }

  public function edit(Room $room)
{
    $roomTypes = RoomType::all();
    $amenities = \App\Models\Amenity::where('status',1)->get();

    $room->load('amenities');

    return view(
        'backend.rooms.edit',
        compact('room','roomTypes','amenities')
    );
}

    public function update(UpdateRoomRequest $request, Room $room)
    {
        $this->service->update($room, $request->validated());

        return redirect()
            ->route('admin.rooms.index')
            ->withFlashSuccess('Room Updated Successfully.');
    }

    public function destroy(Room $room)
    {
        $this->service->delete($room);

        return redirect()
            ->route('admin.rooms.index')
            ->withFlashSuccess('Room Deleted Successfully.');
    }
}