<?php

namespace App\Models;
use App\Models\Booking;

use Illuminate\Database\Eloquent\Model;

class Invoice extends Model
{

    protected $fillable = [

        'invoice_no',
        'booking_id',
        'room_charge',
        'extra_charge',
        'tax',
        'discount',
        'total_amount',
        'payment_method',
        'payment_status',
        'paid_amount',
        'remarks',
        'status',

    ];


   public function booking()
{
    return $this->belongsTo(Booking::class, 'booking_id');
}


    public function payments()
    {
        return $this->hasMany(Payment::class);
    }

}