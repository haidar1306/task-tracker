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
        return $this->invalidReason() === null;
    }

    public function invalidReason(): ?string
    {
        $now = Carbon::now();

        if (! $this->status) {
            return 'This coupon is inactive.';
        }

        if ($this->starts_at && $now->lt($this->starts_at)) {
            return 'This coupon is not active yet.';
        }

        if ($this->expires_at && $now->gt($this->expires_at)) {
            return 'This coupon has expired.';
        }

        if ($this->usage_limit !== null && $this->used_count >= $this->usage_limit) {
            return 'This coupon usage limit has been reached.';
        }

        return null;
    }
}