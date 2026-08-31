<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Invoice;
use App\Models\Booking;
use Illuminate\Http\Request;

class InvoiceController extends Controller
{

    public function index()
    {
        $invoices = Invoice::with('booking')
            ->latest()
            ->paginate(5);

        return view('invoices.index', compact('invoices'));
    }



    public function create()
    {
        $bookings = Booking::where('booking_status', 'Checked Out')
            ->get();

        return view('invoices.create', compact('bookings'));
    }



    public function store(Request $request)
    {


        $request->validate([

            'booking_id' => 'required',

            'room_charge' => 'required',

            'total_amount' => 'required',

            'invoice_no' => 'required',

            'extra_charge' => 'required',

            'payment_status' => 'required'

            // '' => 'required',

            



        ]);
        $exists = Invoice::where('booking_id', $request->booking_id)->exists();

        if ($exists) {

            return back()
                ->withInput()
                ->with('error', 'Invoice already exists for this booking.');

        }


        Invoice::create([

            'invoice_no' => 'INV-' . time(),

            'booking_id' => $request->booking_id,

            'room_charge' => $request->room_charge,

            'extra_charge' => $request->extra_charge ?? 0,

            'tax' => $request->tax ?? 0,

            'discount' => $request->discount ?? 0,

            'total_amount' => $request->total_amount,

            'payment_status' => 'Pending',

            'status' => 1,

        ]);


        return redirect()
            ->route('admin.invoices.index')
            ->withFlashSuccess('Invoice created successfully.');

    }



    public function show(Invoice $invoice)
    {
        $invoice->load('payments');

        return view(
            'invoices.show',
            compact('invoice')
        );
    }



    public function destroy(Invoice $invoice)
    {
        $invoice->delete();

        return back()
            ->withFlashSuccess('Invoice deleted.');
    }

}