<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Invoice;
use Illuminate\Support\Facades\Auth;

class InvoiceController extends Controller
{
    public function show(Invoice $invoice)
    {
        abort_unless(Auth::check(), 403);

        $invoice->load(
            'booking.room.roomType',
            'booking.guest',
            'payments'
        );

        abort_unless(
            $invoice->booking &&
            $invoice->booking->guest &&
            $invoice->booking->guest->email === Auth::user()->email,
            403
        );

        return view('frontend.invoices.show', compact('invoice'));
    }
}
