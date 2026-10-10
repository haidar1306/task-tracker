<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class RoomType extends Model
{
    use HasFactory;

    private const HOTEL_LOGO_UPLOADS = [
        'm1o8ttgolqzgici31qxa.png',
        'w7cqw0gwll5hq6jypt5x.png',
    ];

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

    public function rooms()
    {
        return $this->hasMany(Room::class);
    }

    public function getImageUrlAttribute(): ?string
    {
        $image = trim((string) $this->image);

        if ($image === '') {
            return null;
        }

        if (Str::startsWith($image, ['http://', 'https://'])) {
            return $image;
        }

        return asset('storage/' . ltrim($image, '/'));
    }

    public function getRoomPhotoUrlAttribute(): ?string
    {
        $imageUrl = $this->image_url;
        $imagePath = $imageUrl ? (parse_url($imageUrl, PHP_URL_PATH) ?: $imageUrl) : '';

        foreach (self::HOTEL_LOGO_UPLOADS as $logoUpload) {
            if (Str::endsWith($imagePath, $logoUpload)) {
                return null;
            }
        }

        return $imageUrl;
    }
}