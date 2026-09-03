<?php

namespace App\Http\Controllers\Frontend;


use Razorpay\Api\Api;
use Illuminate\Support\Facades\Auth;
use App\Services\ActivityLogService;
use Razorpay\Api\Errors\SignatureVerificationError;
use App\Http\Controllers\Controller;
use App\Notifications\PaymentNotification;
use App\Domains\Auth\Models\User;
use Illuminate\Http\Request;
use App\Models\Payment;
use Illuminate\Support\Facades\DB;
use App\Models\Invoice;

class PaymentController extends Controller
{
    protected $activityLog;
    public function __construct(ActivityLogService $activityLog)
    {
        $this->activityLog = $activityLog;
    }

    public function create(Invoice $invoice)
    {
        $remaining = $invoice->total_amount - $invoice->paid_amount;

        if ($remaining <= 0) {
            return redirect()
                ->route('frontend.invoice.show', $invoice->id)
                ->withFlashSuccess('Invoice already paid.');
        }

        $api = new Api(
            env('RAZORPAY_KEY'),
            env('RAZORPAY_SECRET')
        );

        $order = $api->order->create([
            'receipt' => 'invoice_' . $invoice->id,
            'amount' => $remaining * 100,
            'currency' => 'INR',
        ]);

        return view('frontend.payment.create', compact('invoice', 'remaining', 'order'));
    }
    public function store(Request $request, Invoice $invoice)
    {
        $remaining = $invoice->total_amount - $invoice->paid_amount;

        $request->validate([
            'amount' => [
                'required',
                'numeric',
                'min:1',
                'max:' . $remaining,
            ],

            'payment_method' => [
                'required',
            ],
        ]);



        $remaining = round($invoice->total_amount - $invoice->paid_amount, 2);

        if ($request->amount > $remaining) {
            return back()
                ->withInput()
                ->withFlashDanger("You can pay maximum ₹{$remaining} only.");
        }

        DB::transaction(function () use ($request, $invoice) {

            // 1. Payment record create
            Payment::create([
                'invoice_id' => $invoice->id,
                'payment_date' => now(),
                'amount' => $request->amount,
                'payment_method' => $request->payment_method,
                'payment_status' => 'Paid',
                'transaction_id' => $request->transaction_id,
                'remarks' => $request->remarks,
                'status' => 1,
            ]);

            // 2. Add new payment to existing paid amount
            $newPaidAmount = $invoice->paid_amount + $request->amount;

            // 3. Determine payment status
            if ($newPaidAmount <= 0) {

                $paymentStatus = 'Pending';

            } elseif ($newPaidAmount < $invoice->total_amount) {

                $paymentStatus = 'Partial';

            } else {

                $paymentStatus = 'Paid';

            }

            // 4. Update invoice
            $invoice->update([
                'paid_amount' => $newPaidAmount,
                'payment_status' => $paymentStatus,
            ]);
            // 5. Update booking payment status
            $invoice->booking->update([
                'payment_status' => $paymentStatus,
            ]);
            $admins = User::where('type', User::TYPE_ADMIN)->get();

            foreach ($admins as $admin) {
                $admin->notify(new PaymentNotification($invoice));
            }
        });
        return redirect()
            ->route('frontend.invoice.show', $invoice->id)
            ->withFlashSuccess('Payment completed successfully.');
    }




    public function verify(Request $request)
    {
        \Log::info('VERIFY REQUEST', $request->all());

        \Log::info('Razorpay Verify Request', [
            'invoice_id' => $request->invoice_id,
            'order_id' => $request->razorpay_order_id,
            'payment_id' => $request->razorpay_payment_id,
        ]);
        try {

            $api = new Api(
                env('RAZORPAY_KEY'),
                env('RAZORPAY_SECRET')
            );

            // Verify Razorpay Signature
            $api->utility->verifyPaymentSignature([
                'razorpay_order_id' => $request->razorpay_order_id,
                'razorpay_payment_id' => $request->razorpay_payment_id,
                'razorpay_signature' => $request->razorpay_signature,
            ]);

            $invoice = Invoice::findOrFail($request->invoice_id);

            if ($invoice->payment_status == 'Paid') {
                return response()->json([
                    'status' => true,
                    'message' => 'Payment already completed.',
                    'redirect' => route('frontend.invoice.show', $invoice->id),
                ]);
            }
            $remaining = $invoice->total_amount - $invoice->paid_amount;

            if ($remaining <= 0) {

                return response()->json([
                    'status' => true,
                    'message' => 'No payment pending.',
                    'redirect' => route('frontend.invoice.show', $invoice->id),
                ]);

            }

            $alreadyPaid = Payment::where('transaction_id', $request->razorpay_payment_id)->exists();

            if ($alreadyPaid) {
                return response()->json([
                    'status' => true,
                    'message' => 'Payment already verified.',
                    'redirect' => route('frontend.invoice.show', $invoice->id),
                ]);
            }

            DB::transaction(function () use ($invoice, $request) {

                $amount = round($request->amount, 2);

                $remaining = round($invoice->total_amount - $invoice->paid_amount, 2);

                if ($amount <= 0) {
                    throw new \Exception('Invalid payment amount.');
                }

                if ($amount > $remaining) {
                    throw new \Exception('Amount cannot exceed remaining balance.');
                }

                Payment::create([
                    'invoice_id' => $invoice->id,
                    'payment_date' => now(),
                    'amount' => $amount,
                    'payment_method' => 'Razorpay',
                    'payment_status' => 'Paid',
                    'transaction_id' => $request->razorpay_payment_id,
                    'remarks' => 'Paid via Razorpay',
                    'status' => 1,
                ]);

                // Add payment instead of marking full paid
                $newPaidAmount = $invoice->paid_amount + $amount;

                if ($newPaidAmount >= $invoice->total_amount) {
                    $paymentStatus = 'Paid';
                } elseif ($newPaidAmount > 0) {
                    $paymentStatus = 'Partial';
                } else {
                    $paymentStatus = 'Pending';
                }

                $invoice->update([
                    'paid_amount' => $newPaidAmount,
                    'payment_status' => $paymentStatus,
                ]);

                $invoice->booking->update([
                    'payment_status' => $paymentStatus,
                    'status' => $paymentStatus == 'Paid'
                        ? 'Confirmed'
                        : 'Pending',
                ]);

                foreach ($admins as $admin) {
                    $admin->notify(new PaymentNotification($invoice));
                }
            });
            if ($invoice->payment_status == 'Paid') {

                $this->activityLog->log(
                    'Payment',
                    'Full Payment',
                    'Invoice #' . $invoice->id .
                    ' fully paid via Razorpay by ' . auth()->user()->name
                );

            } else {

                $this->activityLog->log(
                    'Payment',
                    'Partial Payment',
                    'Partial payment received for Invoice #' .
                    $invoice->id .
                    ' by ' . auth()->user()->name
                );

            }

            $invoice->refresh();

            $redirect = $invoice->payment_status == 'Paid'
                ? route('frontend.invoice.show', $invoice->id)
                : route('frontend.payment.create', $invoice->id);

            return response()->json([
                'status' => true,
                'message' => 'Payment completed Successfully',
                'redirect' => $redirect,
            ]);


        } catch (SignatureVerificationError $e) {

            $this->activityLog->log(
                'Payment',
                'Verification Failed',
                'Razorpay signature verification failed.'
            );
            return response()->json([
                'status' => false,
                'message' => 'Signature Verification Failed',
                'error' => $e->getMessage(),
            ], 400);

        } catch (\Exception $e) {

            \Log::error('Payment Verification Failed', [
                'invoice_id' => $request->invoice_id,
                'payment_id' => $request->razorpay_payment_id,
                'message' => $e->getMessage(),
                'line' => $e->getLine(),
            ]);
            $this->activityLog->log(
                'Payment',
                'Failed',
                $e->getMessage()
            );

            return response()->json([
                'status' => false,
                'message' => $e->getMessage(),
                'line' => $e->getLine(),
                'file' => $e->getFile(),
            ], 500);
        }
    }
    public function createOrder(Request $request)
    {

        \Log::info('CREATE ORDER AMOUNT', [
            'amount' => $request->amount
        ]);
        $request->validate([
            'invoice_id' => 'required|exists:invoices,id',
            'amount' => 'required|numeric|min:1',
        ]);

        $invoice = Invoice::findOrFail($request->invoice_id);

        $remaining = $invoice->total_amount - $invoice->paid_amount;

        if ($request->amount > $remaining) {
            return response()->json([
                'status' => false,
                'message' => 'Amount exceeds remaining balance.',
            ]);
        }

        $api = new Api(
            env('RAZORPAY_KEY'),
            env('RAZORPAY_SECRET')
        );

        $order = $api->order->create([
            'receipt' => 'inv_' . $invoice->id . '_' . time(),
            'amount' => $request->amount * 100,
            'currency' => 'INR',
        ]);

        return response()->json([
            'status' => true,
            'order' => [
                'id' => $order['id'],
                'amount' => $order['amount'],
                'currency' => $order['currency'],
            ],
        ]);
    }
}









