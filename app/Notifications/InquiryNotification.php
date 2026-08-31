<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\DatabaseMessage;


class InquiryNotification extends Notification
{
    use Queueable;

    protected $inquiry;

    public function __construct($inquiry)
    {
        $this->inquiry = $inquiry;
    }

    public function via($notifiable)
    {
        return ['database'];
    }

    public function toDatabase($notifiable)
    {
        return [
            'title' => 'New Inquiry',
            'message' => 'New inquiry received from ' . $this->inquiry->name,
            'inquiry_id' => $this->inquiry->id,
            'type' => 'inquiry',
            'url' => route('admin.inquiries.index', $this->inquiry->id),
        ];
    }
}