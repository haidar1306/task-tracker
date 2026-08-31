<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    use HasFactory;

    protected $fillable = [
        // 'booking_id',
        'invoice_id',
        'payment_date',
        'amount',
        'payment_method',
        'transaction_id',
        'payment_status',
        'remarks',
        'status',
    ];

    protected $casts = [
        'payment_date' => 'date',
        'status' => 'boolean',
    ];


    public function booking()
    {
        return $this->belongsTo(Booking::class);
    }
    public function invoice()
    {
        return $this->belongsTo(Invoice::class);
    }
}