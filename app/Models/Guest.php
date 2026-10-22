<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Guest extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'first_name',
        'last_name',
        'email',
        'phone',
        'gender',
        'dob',
        'address',
        'city',
        'state',
        'country',
        'zip_code',
        'id_proof_type',
        'id_proof_number',
        'status',
    ];

    protected $casts = [
        'dob' => 'date',
        'status' => 'boolean',
    ];

    public function user()
    {
        return $this->belongsTo(\App\Domains\Auth\Models\User::class, 'user_id');
    }

    public function bookings()
    {
        return $this->hasMany(Booking::class, 'guest_id');
    }

    public function getFullNameAttribute()
    {
        return trim($this->first_name . ' ' . $this->last_name);
    }
}