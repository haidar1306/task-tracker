<?php

namespace App\Notifications;

use App\Models\Inquiry;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class InquiryReplyNotification extends Notification
{
    use Queueable;

    protected $inquiry;

    public function __construct(Inquiry $inquiry)
    {
        $this->inquiry = $inquiry;
    }

    public function via($notifiable)
    {
        return ['database'];
    }

   public function toArray($notifiable)
{
    return [
        'title' => 'Inquiry Reply',
        'message' => 'Your inquiry has been replied by the hotel.',
        'inquiry_id' => $this->inquiry->id,
        'type' => 'inquiry_reply',
        'audience' => 'user',
        'url' => route('frontend.frontend.inquiries.show', $this->inquiry->id),
    ];
}
}