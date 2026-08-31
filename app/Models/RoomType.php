<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RoomType extends Model
{
    use HasFactory;

    protected $table = 'room_types';

    protected $fillable = [
        'image',
        'name',
        'capacity',
        'price',
        'description',
        'status',

    ];

    protected $casts = [
        'capacity' => 'integer',
        'price' => 'decimal:2',
        'status' => 'boolean',
    ];
}