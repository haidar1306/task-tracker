<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Http\Requests\StorePaymentRequest;
use App\Http\Requests\UpdatePaymentRequest;
use App\Models\Booking;
use App\Models\Invoice;
use App\Models\Payment;
use App\Services\PaymentService;

class PaymentController extends Controller
{
    protected $service;

    public function __construct(PaymentService $service)
    {
        $this->service = $service;
    }

    public function index()
    {
        $payments = $this->service->all(5);

        return view('backend.payments.index', compact('payments'));
    }

    public function create()
    {
        $invoices = Invoice::with('booking')->latest()->get();

        return view('backend.payments.create', compact('invoices'));
    }
    public function store(StorePaymentRequest $request)
    {
        $invoice = \App\Models\Invoice::find($request->invoice_id);


        if ($invoice->payment_status == 'Paid') {

            return back()
                ->with('error', 'This invoice is already fully paid.');

        }
        $payment = $this->service->store($request->validated());


        if ($payment->invoice_id) {

            $invoice = \App\Models\Invoice::find($payment->invoice_id);

            $paidAmount = $invoice->payments()->sum('amount');


            $status = $paidAmount >= $invoice->total_amount
                ? 'Paid'
                : 'Pending';


            $invoice->update([
                'paid_amount' => $paidAmount,
                'payment_status' => $status
            ]);


            $payment->update([
                'payment_status' => $status
            ]);
        }
        $invoice = \App\Models\Invoice::find($request->invoice_id);


        if ($invoice->payment_status == 'Paid') {

            return back()
                ->with('error', 'This invoice is already paid. No further payment allowed.');

        }


        return redirect()
            ->route('admin.payments.index')
            ->with('success', 'Payment created successfully.');
    }
    public function edit(Payment $payment)
    {
        $invoices = Invoice::with('booking')->latest()->get();

        return view('backend.payments.edit', compact(
            'payment',
            'invoices'
        ));
    }

    public function update(UpdatePaymentRequest $request, Payment $payment)
    {
        $this->service->update($payment, $request->validated());

        return redirect()
            ->route('admin.payments.index')
            ->with('success', 'Payment updated successfully.');
    }

    public function destroy(Payment $payment)
    {
        $this->service->delete($payment);

        return redirect()
            ->route('admin.payments.index')
            ->with('success', 'Payment deleted successfully.');
    }
//     public function verify(Request $request)
// {
//     $api = new Api(env('RAZORPAY_KEY'), env('RAZORPAY_SECRET'));

//     try {

//         $api->utility->verifyPaymentSignature([
//             'razorpay_order_id'   => $request->razorpay_order_id,
//             'razorpay_payment_id' => $request->razorpay_payment_id,
//             'razorpay_signature'  => $request->razorpay_signature,
//         ]);

//         return response()->json([
//             'status' => true,
//             'message' => 'Payment Verified'
//         ]);

//     } catch (\Exception $e) {

//         return response()->json([
//             'status' => false,
//             'message' => $e->getMessage()
//         ]);
//     }
// }
}