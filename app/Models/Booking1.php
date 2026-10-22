<?php

namespace App\Models;

/**
 * Purane code ke liye alias. Naya code sirf App\Models\Booking use kare.
 * Dono ek hi `bookings` table aur ek hi rules use karte hain.
 */
class Booking1 extends Booking
{
    protected $table = 'bookings';
}