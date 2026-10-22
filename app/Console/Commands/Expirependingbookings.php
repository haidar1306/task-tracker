<?php

namespace App\Console\Commands;

use App\Models\Booking;
use App\Services\BookingService;
use Illuminate\Console\Command;

class ExpirePendingBookings extends Command
{
    protected $signature = 'bookings:expire-pending';

    protected $description = 'Mark Pending bookings whose hold time has passed as Expired (room free ho jata hai).';

    public function handle(BookingService $service)
    {
        $count = 0;

        Booking::where('booking_status', Booking::STATUS_PENDING)
            ->whereNotNull('expires_at')
            ->where('expires_at', '<=', now())
            ->get()
            ->each(function (Booking $booking) use ($service, &$count) {
                try {
                    $service->expire($booking);
                    $count++;
                } catch (\Throwable $e) {
                    report($e);
                }
            });

        $this->info("Expired {$count} pending booking(s).");

        return 0;
    }
}