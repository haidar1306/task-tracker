<?php
namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Invoice;

class InvoiceController extends Controller
{

    public function show(Invoice $invoice)
    {
        $invoice->load(  'booking.room.roomType',
            'booking.guest','payments');

        return view('frontend.invoices.show',compact('invoice'));
    }

}
