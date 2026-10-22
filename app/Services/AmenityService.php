<?php

namespace App\Services;

use App\Models\Amenity;
use Illuminate\Support\Facades\DB;

class AmenityService
{
    /**
     * Get all amenities with optional search and pagination.
     */
    public function all($perPage = false, $search = null)
    {
        $query = Amenity::query();

        if (filled($search)) {
            $query->where(function ($query) use ($search) {
                $query->where('name', 'like', '%' . $search . '%')
                    ->orWhere('description', 'like', '%' . $search . '%')
                    ->orWhere('tag', 'like', '%' . $search . '%');
            })->orderByRaw(
                'CASE WHEN name LIKE ? THEN 0 ELSE 1 END',
                [$search . '%']
            );
        }

        $query->latest();

        if (is_numeric($perPage)) {
            return $query->paginate($perPage)->appends(request()->query());
        }

        return $query->get();
    }

    /**
     * Store amenity.
     */
    public function store(array $data): Amenity
    {
        return DB::transaction(function () use ($data) {
            return Amenity::create([
                'name' => $data['name'],
                'description' => $data['description'] ?? null,
                'image' => $data['image'] ?? null,
                'icon' => $data['icon'] ?? null,
                'tag' => $data['tag'] ?? null,
                'status' => $data['status'],
            ]);
        });
    }

    /**
     * Update amenity.
     */
    public function update(Amenity $amenity, array $data): Amenity
    {
        return DB::transaction(function () use ($amenity, $data) {
            $amenity->update([
                'name' => $data['name'],
                'description' => $data['description'] ?? null,
                'image' => $data['image'] ?? null,
                'icon' => $data['icon'] ?? null,
                'tag' => $data['tag'] ?? null,
                'status' => $data['status'],
            ]);

            return $amenity->refresh();
        });
    }

    /**
     * Delete amenity.
     */
    public function delete(Amenity $amenity)
    {
        return DB::transaction(function () use ($amenity) {
            return $amenity->delete();
        });
    }
}