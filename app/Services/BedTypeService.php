<?php

namespace App\Services;

use App\Models\BedType;
use Illuminate\Support\Facades\DB;

class BedTypeService
{
   public function all($perPage = false, $search = null)
{
    $query = BedType::query();

    if (filled($search)) {
        $query->where(function ($query) use ($search) {
            $query->where('name', 'like', '%'.$search.'%')
                ->orWhere('description', 'like', '%'.$search.'%');
        })->orderByRaw('CASE WHEN name LIKE ? THEN 0 ELSE 1 END', [$search.'%']);
    }

    $query->latest();

    if (is_numeric($perPage)) {
        return $query->paginate($perPage)->appends(request()->query());
    }

    return $query->get();
}

    public function store(array $data): BedType
    {
        return DB::transaction(function () use ($data) {

            return BedType::create([
                'name' => $data['name'],
                'description' => $data['description'] ?? null,
                'status' => $data['status'],
            ]);

        });
    }

    public function update(BedType $bedType, array $data): BedType
    {
        DB::transaction(function () use ($bedType, $data) {

            $bedType->update([
                'name' => $data['name'],
                'description' => $data['description'] ?? null,
                'status' => $data['status'],
            ]);

        });

        return $bedType;
    }

    public function delete(BedType $bedType)
    {
        return DB::transaction(function () use ($bedType) {

            return $bedType->delete();

        });
    }
}