<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;


class City extends Model
{

    protected $fillable = [
        'country_id',
        'state_id',
        'name',
    ];


     public function state(): BelongsTo
    {
        return $this->belongsTo(state::class);
    }
    public function country()
    {
        return $this->belongsTo(Country::class);
    }

    

      
    
}