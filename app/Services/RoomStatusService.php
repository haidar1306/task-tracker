<?php

namespace App\Services;

use App\Models\RoomStatus;
use Illuminate\Support\Facades\DB;

class RoomStatusService
{
    /**
     * Get all room statuses.
     */
    public function all($perPage = false, $search = null)
    {
        $query = RoomStatus::query();

        if (filled($search)) {
            $query->where(function ($query) use ($search) {
                $query->where('name', 'like', '%'.$search.'%')
                    ->orWhere('color', 'like', '%'.$search.'%')
                    ->orWhere('description', 'like', '%'.$search.'%');
            })->orderByRaw('CASE WHEN name LIKE ? THEN 0 ELSE 1 END', [$search.'%']);
        }

        $query->latest();
        
        if (is_numeric($perPage)) {
            return $query->paginate($perPage)->appends(request()->query());
        }
        return $query->get();
    }

    /**
     * Store room status.
     */
    public function store(array $data): RoomStatus
    {
        return DB::transaction(function () use ($data) {

            return RoomStatus::create([
                'name'        => $data['name'],
                'color'       => $data['color'],
                'description' => $data['description'] ?? null,
                'status'      => $data['status'],
            ]);

        });
    }

    /**
     * Update room status.
     */
    public function update(RoomStatus $roomStatus, array $data): RoomStatus
    {
        DB::transaction(function () use ($roomStatus, $data) {

            $roomStatus->update([
                'name'        => $data['name'],
                'color'       => $data['color'],
                'description' => $data['description'] ?? null,
                'status'      => $data['status'],
            ]);

        });

        return $roomStatus;
    }

    /**
     * Delete room status.
     */
    public function delete(RoomStatus $roomStatus)
    {
        return DB::transaction(function () use ($roomStatus) {

            return $roomStatus->delete();

        });
    }
}