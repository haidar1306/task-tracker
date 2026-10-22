<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Single source of truth for booking statuses and the allowed transitions.
 */
class Booking extends Model
{
    use HasFactory;

    public const STATUS_PENDING     = 'Pending';
    public const STATUS_CONFIRMED   = 'Confirmed';
    public const STATUS_CHECKED_IN  = 'Checked In';
    public const STATUS_CHECKED_OUT = 'Checked Out';
    public const STATUS_CANCELLED   = 'Cancelled';
    public const STATUS_REJECTED    = 'Rejected';
    public const STATUS_EXPIRED     = 'Expired';
    public const STATUS_NO_SHOW     = 'No Show';

    /** Ye statuses room ko block nahi karte. */
    public const INACTIVE_STATUSES = [
        self::STATUS_CANCELLED,
        self::STATUS_REJECTED,
        self::STATUS_CHECKED_OUT,
        self::STATUS_EXPIRED,
        self::STATUS_NO_SHOW,
    ];

    /** Status machine: kaun se status se kahan jaa sakte hain. */
    public const TRANSITIONS = [
        self::STATUS_PENDING    => [self::STATUS_CONFIRMED, self::STATUS_CANCELLED, self::STATUS_REJECTED, self::STATUS_EXPIRED],
        self::STATUS_CONFIRMED  => [self::STATUS_CHECKED_IN, self::STATUS_CANCELLED, self::STATUS_NO_SHOW],
        self::STATUS_CHECKED_IN => [self::STATUS_CHECKED_OUT],
    ];

    public const PAYMENT_STATUSES = ['Pending', 'Partial', 'Paid', 'Refunded'];

    protected $table = 'bookings';

    protected $fillable = [
        'booking_no',
        'guest_id',
        'room_id',
        'check_in',
        'check_out',
        'adults',
        'children',
        'nightly_rate',
        'total_amount',
        'booking_status',
        'payment_status',
        'remarks',
        'status',
        'idempotency_key',
        'expires_at',
        // API / testing columns (unchanged)
        'source',
        'external_hotel_id',
        'external_hotel_name',
        'external_hotel_image',
    ];

    protected $casts = [
        'check_in'     => 'date',
        'check_out'    => 'date',
        'adults'       => 'integer',
        'children'     => 'integer',
        'nightly_rate' => 'decimal:2',
        'total_amount' => 'decimal:2',
        'status'       => 'boolean',
        'expires_at'   => 'datetime',
    ];

    /* ---------------- Relations ---------------- */

    public function guest()
    {
        return $this->belongsTo(Guest::class, 'guest_id');
    }

    public function room()
    {
        return $this->belongsTo(Room::class, 'room_id');
    }

    public function invoice()
    {
        return $this->hasOne(Invoice::class, 'booking_id');
    }

    /* ---------------- Rules ---------------- */

    public function canTransitionTo(string $to): bool
    {
        return in_array($to, self::TRANSITIONS[$this->booking_status] ?? [], true);
    }

    /** Dates, room aur guests sirf Pending / Confirmed me badal sakte hain. */
    public function isEditable(): bool
    {
        return in_array($this->booking_status, [self::STATUS_PENDING, self::STATUS_CONFIRMED], true);
    }

    public function isBlockingRoom(): bool
    {
        return !in_array($this->booking_status, self::INACTIVE_STATUSES, true);
    }

    /** Check-in tab tak ho sakta hai jab tak stay khatam na hua ho (future booking bhi). */
    public function canCheckInNow(): bool
    {
        return $this->booking_status === self::STATUS_CONFIRMED
            && today()->lt($this->check_out->copy()->startOfDay());
    }

    /** No-show tab jab check-in date nikal chuki ho. */
    public function canMarkNoShow(): bool
    {
        return $this->booking_status === self::STATUS_CONFIRMED
            && today()->gt($this->check_in->copy()->startOfDay());
    }

    public function isCancellableByGuest(): bool
    {
        return in_array($this->booking_status, [self::STATUS_PENDING, self::STATUS_CONFIRMED], true)
            && $this->payment_status === 'Pending'
            && (!$this->invoice || $this->invoice->payment_status === 'Pending');
    }

    public function nights(): int
    {
        return (int) $this->check_in->copy()->startOfDay()->diffInDays($this->check_out->copy()->startOfDay());
    }

    public function badgeClass(): string
    {
        switch ($this->booking_status) {
            case self::STATUS_PENDING:     return 'warning';
            case self::STATUS_CONFIRMED:   return 'success';
            case self::STATUS_CHECKED_IN:  return 'primary';
            case self::STATUS_CHECKED_OUT: return 'secondary';
            case self::STATUS_CANCELLED:
            case self::STATUS_REJECTED:    return 'danger';
            case self::STATUS_EXPIRED:
            case self::STATUS_NO_SHOW:     return 'dark';
            default:                       return 'light';
        }
    }
}