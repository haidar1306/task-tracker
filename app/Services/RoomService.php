<?php

namespace App\Services;

use App\Models\Room;
use Illuminate\Support\Facades\DB;

class RoomService
{
    /**
     * Get all rooms.
     */
    public function all($perPage = false, $search = null)
    {
        $query = Room::with(['roomType']);

        if (filled($search)) {
            $query->where(function ($query) use ($search) {
                $query->where('room_number', 'like', '%'.$search.'%')
                    ->orWhere('floor', 'like', '%'.$search.'%')
                    ->orWhereHas('roomType', function ($query) use ($search) {
                        $query->where('name', 'like', '%'.$search.'%');
                    });
            })->orderByRaw(
                'CASE WHEN room_number LIKE ? THEN 0 WHEN floor LIKE ? THEN 1 ELSE 2 END',
                [$search.'%', $search.'%']
            );
        }

        $query->latest();

        if (is_numeric($perPage)) {
            return $query->paginate($perPage)->appends(request()->query());
        }

        return $query->get();
    }

    /**
     * Store room.
     */
    public function store(array $data): Room
    {
        return DB::transaction(function () use ($data) {

            $room = Room::create([
                'room_number' => $data['room_number'],
                'room_type_id' => $data['room_type_id'],
                'floor' => $data['floor'],
                'status' => $data['status'],
            ]);

            if (isset($data['amenities'])) {
                $room->amenities()->sync($data['amenities']);
            }

            return $room;

        });
    }

    /**
     * Update room.
     */
  public function update(Room $room, array $data): Room
{
    DB::transaction(function () use ($room, $data) {

        $room->update([
            'room_number' => $data['room_number'],
            'room_type_id' => $data['room_type_id'],
            'floor' => $data['floor'],
            'status' => $data['status'],
        ]);


        $room->amenities()->sync(
            $data['amenities'] ?? []
        );

    });

    return $room;
}

    /**
     * Delete room.
     */
    public function delete(Room $room)
    {
        return DB::transaction(function () use ($room) {

            return $room->delete();

        });
    }
}