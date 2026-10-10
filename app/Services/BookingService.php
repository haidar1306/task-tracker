<?php

namespace App\Services;

use App\Models\Booking;
use App\Models\Room;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

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
            $this->assertAvailable($data);

            $data['booking_no'] = 'BK-' . time();

            return Booking::create($data);
        });
    }

    public function update(Booking $booking, array $data): Booking
    {
        DB::transaction(function () use ($booking, $data) {
            $availabilityFields = ['room_id', 'check_in', 'check_out', 'adults', 'children', 'booking_status', 'status'];
            $availabilityChanged = collect($availabilityFields)->contains(function ($field) use ($booking, $data) {
                if (!array_key_exists($field, $data)) {
                    return false;
                }

                $current = $booking->getAttribute($field);
                $requested = $data[$field];

                if (in_array($field, ['check_in', 'check_out'], true)) {
                    return Carbon::parse($current)->toDateString() !== Carbon::parse($requested)->toDateString();
                }

                return (string) $current !== (string) $requested;
            });

            if ($availabilityChanged) {
                $this->assertAvailable($data, $booking->id);
            }

            $booking->update($data);

        });

        return $booking;
    }

    private function assertAvailable(array $data, ?int $ignoreBookingId = null): void
    {
        if (!in_array($data['booking_status'] ?? null, ['Pending', 'Confirmed', 'Checked In'], true)
            || !(bool) ($data['status'] ?? true)) {
            return;
        }

        $room = Room::query()
            ->whereKey($data['room_id'])
            ->lockForUpdate()
            ->first();

        $guestCount = (int) ($data['adults'] ?? 0) + (int) ($data['children'] ?? 0);
        $available = $room && Room::query()
            ->whereKey($room->id)
            ->bookable($guestCount)
            ->availableForStay(
                $data['check_in'],
                $data['check_out'],
                $ignoreBookingId
            )
            ->exists();

        if (!$available) {
            throw ValidationException::withMessages([
                'room_id' => 'The selected room is unavailable for these dates or guest count.',
            ]);
        }
    }

    public function delete(Booking $booking)
    {
        return DB::transaction(function () use ($booking) {

            return $booking->delete();

        });
    }
}