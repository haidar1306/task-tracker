<?php

namespace App\Models;
use App\Models\Invoice;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    use HasFactory;

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
        'check_in' => 'date',
        'check_out' => 'date',
        'status' => 'boolean',
    ];

    public function guest()
    {
        return $this->belongsTo(Guest::class);
    }

    public function room()
    {
        return $this->belongsTo(Room::class);
    }
    public function invoice()
{
    return $this->hasOne(Invoice::class);
}
}