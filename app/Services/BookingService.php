<?php

namespace App\Services;

use App\Models\Booking;
use Illuminate\Support\Facades\DB;

class BookingService
{
    public function all($perPage = false, $search = null, $bookingStatus = null)
{
    $query = Booking::with(['guest', 'room'])
        ->when($bookingStatus, function ($query, $bookingStatus) {
            $query->where('booking_status', $bookingStatus);
        })
        ->latest();

        if (filled($search)) {
            $query->where(function ($query) use ($search) {
                $query->where('booking_no', 'like', '%'.$search.'%')
                    ->orWhereHas('guest', function ($query) use ($search) {
                        $query->where('first_name', 'like', '%'.$search.'%')
                            ->orWhere('last_name', 'like', '%'.$search.'%');
                    });
            });
        }


    if (is_numeric($perPage)) {

        return $query->paginate($perPage)->appends(request()->query());

    }


    return $query->get();
}

    public function store(array $data): Booking
    {
        return DB::transaction(function () use ($data) {

            $data['booking_no'] = 'BK-' . time();

            return Booking::create($data);
        });
    }

    public function update(Booking $booking, array $data): Booking
    {
        DB::transaction(function () use ($booking, $data) {

            $booking->update($data);

        });

        return $booking;
    }

    public function delete(Booking $booking)
    {
        return DB::transaction(function () use ($booking) {

            return $booking->delete();

        });
    }
}