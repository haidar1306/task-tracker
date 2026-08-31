<?php

namespace App\Domains\Website\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GeneralSetting extends Model
{
    use HasFactory;

    /**
     * Table Name
     */
    protected $table = 'general_settings';

    /**
     * Mass Assignable Fields
     */
    protected $fillable = [
        'website_name',
        'website_logo',
        'favicon',
        'email',
        'phone',
        'address',
        'copyright',
        'status',
    ];

    /**
     * Attribute Casting
     */
    protected $casts = [
        'status' => 'boolean',
    ];
}