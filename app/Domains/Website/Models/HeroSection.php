<?php

namespace App\Domains\Website\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HeroSection extends Model
{
    use HasFactory;

    protected $table = 'hero_sections';

    protected $fillable = [
        'badge',
        'heading',
        'description',
        'primary_button_text',
        'primary_button_link',
        'secondary_button_text',
        'secondary_button_link',
        'hero_image',
        'background_image',  
        'background_color', // ADD
        'overlay_opacity',  
        'text_color', 
        'status',
    ];

    protected $casts = [
        'status' => 'boolean',
    ];
}