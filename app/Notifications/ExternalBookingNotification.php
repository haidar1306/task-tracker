<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class ExternalBookingNotification extends Notification
{
    use Queueable;

    protected $booking;
    protected string $title;
    protected string $message;
    protected string $audience;

    public function __construct(
        $booking,
        string $title,
        string $message,
        string $audience = 'admin'
    ) {
        $this->booking = $booking;
        $this->title = $title;
        $this->message = $message;
        $this->audience = $audience;
    }

    public function via($notifiable): array
    {
        return ['database'];
    }

    public function toDatabase($notifiable): array
    {
        $url = $this->audience === 'admin'
            ? route('admin.bookings.external-bookings.show', $this->booking->id)
            : route('frontend.reservation.index');

        return [
            'title' => $this->title,
            'message' => $this->message,
            'booking_id' => $this->booking->id,
            'booking_reference' => $this->booking->booking_reference,
            'type' => 'external_booking',
            'audience' => $this->audience,
            'url' => $url,
        ];
    }
}