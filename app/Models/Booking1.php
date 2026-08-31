<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Booking1 extends Model
{
    use HasFactory;

    protected $table = 'bookings';

    protected $fillable = [
        'booking_no',
        'guest_id',
        'room_id',
        'check_in',
        'check_out',
        'adults',
        'children',
        'total_amount',
        'booking_status',
        'payment_status',
        'remarks',
        'status',
    ];

    protected $casts = [
        'check_in'     => 'date',
        'check_out'    => 'date',
        'adults'       => 'integer',
        'children'     => 'integer',
        'total_amount' => 'decimal:2',
        'status'       => 'boolean',
    ];

    public function room()
    {
        return $this->belongsTo(Room::class);
    }

    public function guest()
    {
        return $this->belongsTo(Guest::class, 'guest_id');
    }
    public function invoice()
{
    return $this->hasOne(Invoice::class, 'booking_id');
}
}