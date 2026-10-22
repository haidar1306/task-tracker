<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
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
        'bed_type_id',
    ];

    protected $casts = [
        'floor' => 'integer',
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
    public function bedType()
    {
        return $this->belongsTo(\App\Models\BedType::class, 'bed_type_id');
    }

    public function scopeBookable(Builder $query, ?int $guests = null): Builder
    {
        return $query
            ->where('status', '!=', 'maintenance')
            ->whereHas('roomType', function (Builder $roomTypes) use ($guests) {
                $roomTypes->where('status', true);

                if ($guests !== null) {
                    $roomTypes->where('capacity', '>=', $guests);
                }
            });
    }

    /**
     * Rooms jinki koi active booking given dates se overlap nahi karti.
     * Overlap: existing.check_in < new.check_out AND existing.check_out > new.check_in
     */
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
                ->where(function (Builder $q) {
                    $q->whereNull('booking_status')
                        ->orWhereNotIn('booking_status', Booking1::INACTIVE_STATUSES);
                })
                ->whereDate('check_in', '<', $checkOut)
                ->whereDate('check_out', '>', $checkIn);
        });
    }
}