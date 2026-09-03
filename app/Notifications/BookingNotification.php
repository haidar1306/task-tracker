<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class BookingNotification extends Notification
{
    use Queueable;

    protected $booking;

    public function __construct($booking)
    {
        $this->booking = $booking;
    }

    public function via($notifiable)
    {
        return ['database'];    
    }

   public function toDatabase($notifiable)
{
    return [
        'title' => 'New Booking',
        'message' => 'New booking received from ' . $this->booking->guest->first_name,
        'booking_id' => $this->booking->id,
        'type' => 'booking',
        'audience' => 'admin',
        'url' => route('admin.bookings.show', $this->booking->id), // <-- add this
    ];
}
}