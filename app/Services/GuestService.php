<?php

namespace App\Services;

use App\Models\Guest;
use Illuminate\Support\Facades\DB;

class GuestService
{
    public function all($perPage = false, $search = null)
    {
        $query = Guest::latest();

        if (filled($search)) {
            $query->where(function ($query) use ($search) {
                $query->where('first_name', 'like', '%'.$search.'%')
                    ->orWhere('last_name', 'like', '%'.$search.'%')
                    ->orWhere('email', 'like', '%'.$search.'%');
            })->orderByRaw(
                'CASE WHEN first_name LIKE ? THEN 0 WHEN last_name LIKE ? THEN 1 WHEN email LIKE ? THEN 2 ELSE 3 END',
                [$search.'%', $search.'%', $search.'%']
            );
        }

        if (is_numeric($perPage)) {
            return $query->paginate($perPage);
        }

        return $query->get();
    }

    public function store(array $data): Guest
    {
        return DB::transaction(function () use ($data) {
            return Guest::create($data);
        });
    }

    public function update(Guest $guest, array $data): Guest
    {
        DB::transaction(function () use ($guest, $data) {
            $guest->update($data);
        });

        return $guest;
    }

    public function delete(Guest $guest)
    {
        return DB::transaction(function () use ($guest) {
            return $guest->delete();
        });
    }
}   