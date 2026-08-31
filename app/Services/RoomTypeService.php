<?php

namespace App\Services;

use App\Models\RoomType;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class RoomTypeService
{
    /**
     * Get all room types.
     *
    * @return \Illuminate\Database\Eloquent\Collection|\Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
   public function all($perPage = false, $search = null)
{
    $query = RoomType::where('status', true);

    if (filled($search)) {
        $query->where('name', 'like', '%'.$search.'%')
            ->orderByRaw('CASE WHEN name LIKE ? THEN 0 ELSE 1 END', [$search.'%'])
            ->orderBy('name');
    } else {
        $query->orderBy('name');
    }

    if (is_numeric($perPage)) {
        return $query->paginate($perPage)->appends(request()->query());
    }

    return $query->get();
}

    /**
     * Store room type.
     *
     * @param array $data
     * @return RoomType
     */
    public function store(array $data): RoomType
    {
        // dd($data);
        return DB::transaction(function () use ($data) {
            $image = null;

            if (isset($data['image'])) {
                $image = $data['image']->store('room-types', 'public');
            }

            return RoomType::create([
                'name' => $data['name'],
                'capacity' => $data['capacity'],
                'price' => $data['price'],
                'description' => $data['description'] ?? null,
                'image' => $image,
                'status' => $data['status'] ?? 1,
            ]);
        });
    }

    /**
     * Update room type.
     *
     * @param RoomType $roomType
     * @param array $data
     * @return RoomType
     */
    public function update(RoomType $roomType, array $data): RoomType
    {
       DB::transaction(function () use ($roomType, $data) {

    $image = $roomType->image;

    if (isset($data['image'])) {

        if ($roomType->image && Storage::disk('public')->exists($roomType->image)) {
            Storage::disk('public')->delete($roomType->image);
        }

        $image = $data['image']->store('room-types', 'public');
    }

    $roomType->update([
        'name'        => $data['name'],
        'capacity'    => $data['capacity'],
        'price'       => $data['price'],
        'description' => $data['description'] ?? null,
        'image'       => $image,
        'status'      => $data['status'] ?? $roomType->status,
    ]);
});

        return $roomType;
    }

    /**
     * Delete room type.
     *
     * @param RoomType $roomType
     * @return bool|null
     */
    public function delete(RoomType $roomType)
    {
        return DB::transaction(function () use ($roomType) {
            return $roomType->delete();
        });
    }
}