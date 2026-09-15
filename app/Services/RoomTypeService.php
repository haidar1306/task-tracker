<?php

namespace App\Services;

use App\Models\RoomType;
use Illuminate\Support\Facades\DB;
use CloudinaryLabs\CloudinaryLaravel\Facades\Cloudinary;

class RoomTypeService
{
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

    public function store(array $data): RoomType
    {
        return DB::transaction(function () use ($data) {
            $image = null;

            if (isset($data['image'])) {
                $uploaded = Cloudinary::upload($data['image']->getRealPath(), [
                    'folder' => 'room-types',
                ]);
                $image = $uploaded->getSecurePath();
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

    public function update(RoomType $roomType, array $data): RoomType
    {
        DB::transaction(function () use ($roomType, $data) {

            $image = $roomType->image;

            if (isset($data['image'])) {
                $uploaded = Cloudinary::upload($data['image']->getRealPath(), [
                    'folder' => 'room-types',
                ]);
                $image = $uploaded->getSecurePath();
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

    public function delete(RoomType $roomType)
    {
        return DB::transaction(function () use ($roomType) {
            return $roomType->delete();
        });
    }
}