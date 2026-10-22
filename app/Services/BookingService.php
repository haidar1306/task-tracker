<?php

namespace App\Services;

use App\Models\Booking;
use App\Models\Guest;
use App\Models\Invoice;
use App\Models\Room;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;

/**
 * Saare booking rules yahin hain. Controller / form / admin koi bhi inhe bypass nahi kar sakta.
 */
class BookingService
{
    public const MAX_STAY_NIGHTS       = 30;
    public const MAX_PENDING_PER_GUEST = 3;
    public const PENDING_HOLD_HOURS    = 24;

    /* =========================================================
     | Listing
     ========================================================= */

    public function all($perPage = false, $search = null, $bookingStatus = null)
    {
        $query = Booking::with(['guest', 'room'])
            ->when($bookingStatus, fn ($q, $status) => $q->where('booking_status', $status))
            ->latest();

        if (filled($search)) {
            $query->where(function ($q) use ($search) {
                $q->where('booking_no', 'like', '%' . $search . '%')
                    ->orWhereHas('guest', function ($g) use ($search) {
                        $g->where('first_name', 'like', '%' . $search . '%')
                            ->orWhere('last_name', 'like', '%' . $search . '%');
                    });
            });
        }

        if (is_numeric($perPage)) {
            return $query->paginate($perPage)->appends(request()->query());
        }

        return $query->get();
    }

    /* =========================================================
     | Read-only helper (page dikhane ke liye, lock nahi)
     ========================================================= */

    public function canBook(Room $room, int $guests, ?string $in, ?string $out): bool
    {
        $room->loadMissing('roomType');

        if (!$room->roomType || !$room->roomType->status || $room->status === 'maintenance') {
            return false;
        }

        if ($guests > (int) $room->roomType->capacity) {
            return false;
        }

        return Room::query()
            ->whereKey($room->id)
            ->availableForStay($in, $out)
            ->exists();
    }

    /* =========================================================
     | Guest
     ========================================================= */

    public function guestForUser($user): Guest
    {
        $guest = Guest::where('user_id', $user->id)->first()
            ?? Guest::where('email', $user->email)->first();

        if ($guest) {
            if (!$guest->user_id) {
                $guest->forceFill(['user_id' => $user->id])->save();
            }

            return $guest;
        }

        $parts = explode(' ', trim((string) $user->name), 2);

        return Guest::create([
            'user_id'    => $user->id,
            'email'      => $user->email,
            'first_name' => $parts[0] ?? '',
            'last_name'  => $parts[1] ?? '',
            'phone'      => $user->phone ?? '',
            'status'     => true,
        ]);
    }

    /* =========================================================
     | Create
     ========================================================= */

    /**
     * Frontend booking. Returns [Booking, bool $created].
     * Same idempotency_key dobara aaye (double click / retry) to wahi booking milti hai.
     */
    public function createForUser($user, array $data): array
    {
        $created = true;

        $booking = DB::transaction(function () use ($user, $data, &$created) {
            $room = $this->lockRoom((int) $data['room_id']);

            $key = $data['idempotency_key'] ?? null;

            if ($key) {
                $existing = Booking::where('idempotency_key', $key)->first();

                if ($existing) {
                    $created = false;

                    return $existing;
                }
            }

            $adults   = (int) $data['adults'];
            $children = (int) ($data['children'] ?? 0);

            $this->assertDates($data['check_in'], $data['check_out'], true, true);
            $this->assertBookable($room, $adults + $children);

            $guest = $this->guestForUser($user);
            $this->assertNoRepeatBooking($guest->id, $room->id, $data['check_in'], $data['check_out']);
            $this->assertFree($room->id, $data['check_in'], $data['check_out']);
            $this->assertPendingLimit($guest);

            return $this->persist($room, $guest->id, $data, Booking::STATUS_PENDING, $key);
        });

        return [$booking, $created];
    }

    /** Admin booking (Pending ya Confirmed se shuru). */
    public function createByAdmin(array $data): Booking
    {
        return DB::transaction(function () use ($data) {
            $room = $this->lockRoom((int) $data['room_id']);

            $this->assertDates($data['check_in'], $data['check_out'], true, false);
            $this->assertBookable($room, (int) $data['adults'] + (int) ($data['children'] ?? 0));
            $this->assertNoRepeatBooking((int) $data['guest_id'], $room->id, $data['check_in'], $data['check_out']);
            $this->assertFree($room->id, $data['check_in'], $data['check_out']);

            return $this->persist(
                $room,
                (int) $data['guest_id'],
                $data,
                $data['booking_status'] ?? Booking::STATUS_PENDING
            );
        });
    }

    /* =========================================================
     | Update (status yahan se kabhi nahi badalta)
     ========================================================= */

    public function update(Booking $booking, array $data): Booking
    {
        return DB::transaction(function () use ($booking, $data) {
            $booking = $this->lockBooking($booking);

            // Hamesha allowed: payment, remarks, active flag.
            $payload = array_intersect_key($data, array_flip(['payment_status', 'remarks', 'status']));

            if ($booking->isEditable()) {
                $roomId   = (int) ($data['room_id'] ?? $booking->room_id);
                $room     = $this->lockRoom($roomId);
                $in       = Carbon::parse($data['check_in'] ?? $booking->check_in)->toDateString();
                $out      = Carbon::parse($data['check_out'] ?? $booking->check_out)->toDateString();
                $adults   = (int) ($data['adults'] ?? $booking->adults);
                $children = (int) ($data['children'] ?? $booking->children);

                $roomChanged  = $roomId !== (int) $booking->room_id;
                $datesChanged = $in !== $booking->check_in->toDateString()
                    || $out !== $booking->check_out->toDateString();

                $this->assertDates($in, $out, $datesChanged || $roomChanged, false);
                $this->assertBookable($room, $adults + $children);
                $this->assertNoRepeatBooking(
                    (int) ($data['guest_id'] ?? $booking->guest_id),
                    $room->id,
                    $in,
                    $out,
                    $booking->id
                );
                $this->assertFree($room->id, $in, $out, $booking->id);

                $rate   = ($roomChanged || !$booking->nightly_rate)
                    ? (float) $room->roomType->price
                    : (float) $booking->nightly_rate;
                $nights = Carbon::parse($in)->diffInDays(Carbon::parse($out));

                $payload = array_merge($payload, [
                    'guest_id'     => $data['guest_id'] ?? $booking->guest_id,
                    'room_id'      => $room->id,
                    'check_in'     => $in,
                    'check_out'    => $out,
                    'adults'       => $adults,
                    'children'     => $children,
                    'nightly_rate' => $rate,
                    'total_amount' => $rate * $nights,
                ]);
            }

            $booking->update($payload);

            return $booking;
        });
    }

    /* =========================================================
     | Status actions
     ========================================================= */

    public function confirm(Booking $booking): Booking
    {
        return DB::transaction(function () use ($booking) {
            $booking = $this->lockBooking($booking);
            $this->assertTransition($booking, Booking::STATUS_CONFIRMED);

            $this->lockRoom((int) $booking->room_id);
            $this->assertFree(
                $booking->room_id,
                $booking->check_in->toDateString(),
                $booking->check_out->toDateString(),
                $booking->id
            );

            $booking->update(['booking_status' => Booking::STATUS_CONFIRMED, 'expires_at' => null]);

            return $booking;
        });
    }

    public function reject(Booking $booking): Booking
    {
        return $this->simpleTransition($booking, Booking::STATUS_REJECTED);
    }

    public function cancel(Booking $booking): Booking
    {
        return $this->simpleTransition($booking, Booking::STATUS_CANCELLED);
    }

    public function expire(Booking $booking): Booking
    {
        return $this->simpleTransition($booking, Booking::STATUS_EXPIRED);
    }

    public function markNoShow(Booking $booking): Booking
    {
        return DB::transaction(function () use ($booking) {
            $booking = $this->lockBooking($booking);
            $this->assertTransition($booking, Booking::STATUS_NO_SHOW);

            if (!$booking->canMarkNoShow()) {
                throw ValidationException::withMessages([
                    'booking_status' => 'No-show can be marked only after the check-in date has passed.',
                ]);
            }

            $booking->update(['booking_status' => Booking::STATUS_NO_SHOW]);

            return $booking;
        });
    }

    public function checkIn(Booking $booking): Booking
    {
        return DB::transaction(function () use ($booking) {
            $booking = $this->lockBooking($booking);
            $this->assertTransition($booking, Booking::STATUS_CHECKED_IN);

            // Future booking bhi check in ho sakti hai; sirf wo booking nahi jiska stay khatam ho chuka.
            if (today()->gte($booking->check_out->copy()->startOfDay())) {
                throw ValidationException::withMessages([
                    'booking_status' => 'The stay period of this booking has already ended.',
                ]);
            }

            $room = $this->lockRoom((int) $booking->room_id);

            if ($room->status === 'maintenance') {
                throw ValidationException::withMessages([
                    'booking_status' => 'This room is under maintenance.',
                ]);
            }

            $otherGuest = Booking::where('room_id', $room->id)
                ->where('booking_status', Booking::STATUS_CHECKED_IN)
                ->where('id', '<>', $booking->id)
                ->whereDate('check_in', '<', $booking->check_out->toDateString())
                ->whereDate('check_out', '>', $booking->check_in->toDateString())
                ->exists();

            if ($otherGuest) {
                throw ValidationException::withMessages([
                    'booking_status' => 'Another guest is already checked in to this room for overlapping dates.',
                ]);
            }

            $booking->update(['booking_status' => Booking::STATUS_CHECKED_IN]);

            // Room "occupied" tabhi jab guest ka stay aaj chal raha ho.
            // Future booking check in ho to room baaki dates ke liye band nahi hota.
            $staysToday = today()->gte($booking->check_in->copy()->startOfDay())
                && today()->lt($booking->check_out->copy()->startOfDay());

            if ($staysToday) {
                $room->update(['status' => 'occupied']);
            }

            return $booking;
        });
    }

    public function checkOut(Booking $booking): Booking
    {
        return DB::transaction(function () use ($booking) {
            $booking = $this->lockBooking($booking);
            $this->assertTransition($booking, Booking::STATUS_CHECKED_OUT);

            $booking->update(['booking_status' => Booking::STATUS_CHECKED_OUT]);

            $room = $this->lockRoom((int) $booking->room_id);

            $stillOccupied = Booking::where('room_id', $room->id)
                ->where('booking_status', Booking::STATUS_CHECKED_IN)
                ->whereDate('check_in', '<=', today()->toDateString())
                ->whereDate('check_out', '>', today()->toDateString())
                ->exists();

            if (!$stillOccupied && $room->status === 'occupied') {
                $room->update(['status' => 'available']);
            }

            Invoice::firstOrCreate(
                ['booking_id' => $booking->id],
                [
                    'invoice_no'     => 'INV-' . now()->format('ymd') . '-' . strtoupper(Str::random(6)),
                    'room_charge'    => $booking->total_amount,
                    'extra_charge'   => 0,
                    'tax'            => 0,
                    'discount'       => 0,
                    'total_amount'   => $booking->total_amount,
                    'payment_method' => null,
                    'payment_status' => 'Pending',
                    'paid_amount'    => 0,
                    'remarks'        => null,
                    'status'         => true,
                ]
            );

            return $booking;
        });
    }

    public function delete(Booking $booking): bool
    {
        return DB::transaction(function () use ($booking) {
            $booking = $this->lockBooking($booking);

            if ($booking->booking_status === Booking::STATUS_CHECKED_IN) {
                throw ValidationException::withMessages([
                    'booking_status' => 'A checked-in booking cannot be deleted. Check the guest out first.',
                ]);
            }

            return (bool) $booking->delete();
        });
    }

    /* =========================================================
     | Internals
     ========================================================= */

    private function simpleTransition(Booking $booking, string $to): Booking
    {
        return DB::transaction(function () use ($booking, $to) {
            $booking = $this->lockBooking($booking);
            $this->assertTransition($booking, $to);
            $booking->update(['booking_status' => $to]);

            return $booking;
        });
    }

    private function persist(Room $room, int $guestId, array $data, string $status, ?string $key = null): Booking
    {
        $rate   = (float) $room->roomType->price;
        $nights = Carbon::parse($data['check_in'])->diffInDays(Carbon::parse($data['check_out']));

        return Booking::create([
            'booking_no'      => $this->newBookingNo(),
            'guest_id'        => $guestId,
            'room_id'         => $room->id,
            'check_in'        => $data['check_in'],
            'check_out'       => $data['check_out'],
            'adults'          => (int) $data['adults'],
            'children'        => (int) ($data['children'] ?? 0),
            'nightly_rate'    => $rate,
            'total_amount'    => $rate * $nights,
            'booking_status'  => $status,
            'payment_status'  => $data['payment_status'] ?? 'Pending',
            'remarks'         => $data['remarks'] ?? null,
            'status'          => (bool) ($data['status'] ?? true),
            'idempotency_key' => $key,
            'expires_at'      => $status === Booking::STATUS_PENDING
                ? now()->addHours(self::PENDING_HOLD_HOURS)
                : null,
        ]);
    }

    private function newBookingNo(): string
    {
        do {
            $no = 'BK-' . strtoupper(Str::random(10));
        } while (Booking::where('booking_no', $no)->exists());

        return $no;
    }

    private function lockRoom(int $roomId): Room
    {
        return Room::with('roomType')->whereKey($roomId)->lockForUpdate()->firstOrFail();
    }

    private function lockBooking(Booking $booking): Booking
    {
        return Booking::whereKey($booking->id)->lockForUpdate()->firstOrFail();
    }

    private function assertTransition(Booking $booking, string $to): void
    {
        if (!$booking->canTransitionTo($to)) {
            throw ValidationException::withMessages([
                'booking_status' => 'A "' . $booking->booking_status . '" booking cannot be moved to "' . $to . '".',
            ]);
        }
    }

    /**
     * Same guest + same room + overlapping dates dobara book nahi ho sakta,
     * chahe pehli booking Checked Out ho chuki ho.
     * Sirf Cancelled / Rejected / Expired / No Show ko ignore karte hain (user dobara try kar sake).
     */
    private function assertNoRepeatBooking(int $guestId, int $roomId, string $in, string $out, ?int $ignoreBookingId = null): void
    {
        $previous = Booking::query()
            ->where('guest_id', $guestId)
            ->where('room_id', $roomId)
            ->whereNotIn('booking_status', [
                Booking::STATUS_CANCELLED,
                Booking::STATUS_REJECTED,
                Booking::STATUS_EXPIRED,
                Booking::STATUS_NO_SHOW,
            ])
            ->whereDate('check_in', '<', $out)
            ->whereDate('check_out', '>', $in)
            ->when($ignoreBookingId, fn ($q) => $q->where('id', '<>', $ignoreBookingId))
            ->first();

        if ($previous) {
            throw ValidationException::withMessages([
                'check_in' => 'You have already booked this room for these dates (' . $previous->booking_no
                    . '). Please choose different dates.',
            ]);
        }
    }

    private function assertBookable(Room $room, int $guests): void
    {
        if (!$room->roomType || !$room->roomType->status) {
            throw ValidationException::withMessages([
                'room_id' => 'This room type is not available for booking.',
            ]);
        }

        if ($room->status === 'maintenance') {
            throw ValidationException::withMessages([
                'room_id' => 'This room is under maintenance.',
            ]);
        }

        if ($guests < 1 || $guests > (int) $room->roomType->capacity) {
            throw ValidationException::withMessages([
                'adults' => 'This room can host a maximum of ' . (int) $room->roomType->capacity . ' guests.',
            ]);
        }
    }

    private function assertFree(int $roomId, string $in, string $out, ?int $ignoreBookingId = null): void
    {
        $free = Room::query()
            ->whereKey($roomId)
            ->availableForStay($in, $out, $ignoreBookingId)
            ->exists();

        if (!$free) {
            throw ValidationException::withMessages([
                'check_in' => 'This room is already booked for the selected dates. Please choose different dates.',
            ]);
        }
    }

    private function assertDates($in, $out, bool $enforceFuture, bool $enforceLimits): void
    {
        $in  = Carbon::parse($in)->startOfDay();
        $out = Carbon::parse($out)->startOfDay();

        if ($out->lte($in)) {
            throw ValidationException::withMessages(['check_out' => 'Check-out must be after check-in.']);
        }

        if ($enforceFuture && $in->lt(today())) {
            throw ValidationException::withMessages(['check_in' => 'Check-in date cannot be in the past.']);
        }

        if ($enforceLimits) {
            if ($in->diffInDays($out) > self::MAX_STAY_NIGHTS) {
                throw ValidationException::withMessages([
                    'check_out' => 'You can book a maximum of ' . self::MAX_STAY_NIGHTS . ' nights at a time.',
                ]);
            }

            if ($out->gt(today()->addYear())) {
                throw ValidationException::withMessages([
                    'check_out' => 'Check-out cannot be more than a year from today.',
                ]);
            }
        }
    }

    private function assertPendingLimit(Guest $guest): void
    {
        $pending = Booking::where('guest_id', $guest->id)
            ->where('booking_status', Booking::STATUS_PENDING)
            ->count();

        if ($pending >= self::MAX_PENDING_PER_GUEST) {
            throw ValidationException::withMessages([
                'room_id' => 'You already have ' . self::MAX_PENDING_PER_GUEST
                    . ' reservations awaiting confirmation. Please wait for them to be confirmed or cancel one.',
            ]);
        }
    }
}