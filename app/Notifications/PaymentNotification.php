<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\DatabaseMessage;

class PaymentNotification extends Notification
{
    use Queueable;

    protected $invoice;
    public function __construct($invoice)
    {
        $this->invoice = $invoice;
    }
    public function via($notifiable)
    {
        return ['database'];
    }

    public function toDatabase($notifiable)
    {
        return [
            'title' => 'Payment Received',
            'message' => 'Payment received for Invoice #' . $this->invoice->invoice_no,
            'invoice_id' => $this->invoice->id,
            'type' => 'payment',
            'audience' => 'admin',
            'url' => route('admin.invoices.show', $this->invoice->id),
        ];
    }
}