<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

class Coupon extends Model
{
    use HasFactory;

    protected $fillable = [
        'code',
        'discount_type',
        'discount_value',
        'minimum_amount',
        'maximum_discount',
        'starts_at',
        'expires_at',
        'usage_limit',
        'used_count',
        'status',
        'description',
    ];

    protected $casts = [
        'starts_at' => 'datetime',
        'expires_at' => 'datetime',
        'status' => 'boolean',
    ];

    /**
     * Check whether coupon is currently valid.
     */
    public function isValid(): bool
    {
        $now = Carbon::now();

        if (!$this->status) {
            return false;
        }

        if ($this->starts_at && $now->lt($this->starts_at)) {
            return false;
        }

        if ($this->expires_at && $now->gt($this->expires_at)) {
            return false;
        }

        if ($this->usage_limit !== null &&
            $this->used_count >= $this->usage_limit) {
            return false;
        }

        return true;
    }
}