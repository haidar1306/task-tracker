<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ExternalBooking extends Model
{
    protected $table = 'external_bookings';

    protected $fillable = [
        'user_id',
        'hotel_id',
        'hotel_name',
        'hotel_image',
        'check_in',
        'check_out',
        'guests',
        'total_price',
        'currency',
        'status',
        'payment_status',
        'booking_reference',
        'razorpay_order_id',
        'razorpay_payment_id',
        'payment_method',
        'paid_at',
    ];

    protected $casts = [
        'check_in' => 'date',
        'check_out' => 'date',
        'guests' => 'integer',
        'total_price' => 'decimal:2',
        'paid_at' => 'datetime',
    ];
}
