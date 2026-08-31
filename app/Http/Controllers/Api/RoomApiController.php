<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Room;

class RoomApiController extends Controller
{
    
public function index()
{
    $rooms = Room::get();

    return response()->json([
        'success' => true,
        'data' => $rooms
    ]);
}

public function show(Room $room)
{
    return response()->json([
        'success' => true,
        'data' => $room
    ]);
}
public function store(Request $request)
{
    $room = Room::create([
        'room_number' => $request->room_number,
        'room_type_id' => $request->room_type_id,
        'floor' => $request->floor,
        'status' => $request->status,
    ]);

    return response()->json([
        'success' => true,
        'message' => 'Room Created Successfully',
        'data' => $room
    ], 201);
}
public function update(Request $request, Room $room)
{
    $room->update([
        'room_number' => $request->room_number,
        'room_type_id' => $request->room_type_id,
        'floor' => $request->floor,
        'status' => $request->status,
    ]);

    return response()->json([
        'success' => true,
        'message' => 'Room Updated Successfully',
        'data' => $room
    ]);
}
public function destroy(Room $room)
{
    $room->delete();

    return response()->json([
        'success' => true,
        'message' => 'Room Deleted Successfully'
    ], 200);
}
}
