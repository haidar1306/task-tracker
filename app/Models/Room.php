<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Amenity;


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
}