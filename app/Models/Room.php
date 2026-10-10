<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class Room extends Model
{
    use HasFactory;

    protected $table = 'rooms';

    protected $fillable = [
        'room_number',
        'room_type_id',
        'floor',
        'status',
    ];

    protected $casts = [
        'floor' => 'integer',
        // 'status' => 'boolean',
    ];

    public function roomType()
    {
        return $this->belongsTo(RoomType::class);
    }

    public function amenities()
    {
        return $this->belongsToMany(Amenity::class);
    }

    public function bookings()
    {
        return $this->hasMany(Booking1::class, 'room_id');
    }

    public function scopeBookable(Builder $query, ?int $guests = null): Builder
    {
        return $query
            ->where('status', 'available')
            ->whereHas('roomType', function (Builder $roomTypes) use ($guests) {
                $roomTypes->where('status', true);

                if ($guests !== null) {
                    $roomTypes->where('capacity', '>=', $guests);
                }
            });
    }

    public function scopeAvailableForStay(
        Builder $query,
        ?string $checkIn,
        ?string $checkOut,
        ?int $ignoreBookingId = null
    ): Builder {
        if (!$checkIn || !$checkOut) {
            return $query;
        }

        return $query->whereDoesntHave('bookings', function (Builder $bookings) use ($checkIn, $checkOut, $ignoreBookingId) {
            if ($ignoreBookingId !== null) {
                $bookings->where('id', '<>', $ignoreBookingId);
            }

            $bookings
                ->where('status', true)
                ->whereIn('booking_status', ['Pending', 'Confirmed', 'Checked In'])
                ->whereDate('check_in', '<', $checkOut)
                ->whereDate('check_out', '>', $checkIn);
        });
    }
}