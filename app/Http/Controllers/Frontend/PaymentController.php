<?php

namespace App\Http\Controllers\Frontend;

use App\Domains\Auth\Models\User;
use App\Http\Controllers\Controller;
use App\Models\Booking1;
use App\Models\Coupon;
use App\Models\Invoice;
use App\Models\Payment;
use App\Notifications\PaymentNotification;
use App\Services\ActivityLogService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Razorpay\Api\Api;
use Razorpay\Api\Errors\SignatureVerificationError;

class PaymentController extends Controller
{
    protected $activityLog;

    public function __construct(ActivityLogService $activityLog)
    {
        $this->activityLog = $activityLog;
    }

    /**
     * Payment page.
     */
    public function create(Invoice $invoice)
    {
        $invoice->loadMissing('booking.guest');

        $this->authorizeInvoiceOwner($invoice);
        $this->assertPayable($invoice);

        $remaining = $this->remaining($invoice);

        if ($remaining <= 0) {
            return redirect()
                ->route('invoice.show', $invoice->id)
                ->withFlashSuccess('Invoice already paid.');
        }

        try {
            $order = $this->razorpay()->order->create([
                'receipt'  => 'inv_' . $invoice->id . '_' . time(),
                'amount'   => $this->toPaise($remaining),
                'currency' => 'INR',
                'notes'    => ['invoice_id' => (string) $invoice->id],
            ]);
        } catch (\Throwable $e) {
            report($e);

            return back()->withFlashDanger('Payment service is unavailable. Please try again.');
        }

        return view('frontend.payment.create', compact('invoice', 'remaining', 'order'));
    }

    /**
     * Create a Razorpay order (AJAX).
     */
    public function createOrder(Request $request): JsonResponse
    {
        $data = $request->validate([
            'invoice_id' => ['required', 'integer', 'exists:invoices,id'],
            'amount'     => ['required', 'numeric', 'min:1'],
        ]);

        $invoice = Invoice::with('booking.guest')->findOrFail($data['invoice_id']);

        $this->authorizeInvoiceOwner($invoice);
        $this->assertPayable($invoice);

        $amount    = round((float) $data['amount'], 2);
        $remaining = $this->remaining($invoice);

        if ($amount > $remaining) {
            return response()->json([
                'status'  => false,
                'message' => 'Amount exceeds remaining balance.',
            ], 422);
        }

        try {
            $order = $this->razorpay()->order->create([
                'receipt'  => 'inv_' . $invoice->id . '_' . time(),
                'amount'   => $this->toPaise($amount),
                'currency' => 'INR',
                'notes'    => ['invoice_id' => (string) $invoice->id],
            ]);
        } catch (\Throwable $e) {
            report($e);

            return response()->json([
                'status'  => false,
                'message' => 'Could not start the payment. Please try again.',
            ], 502);
        }

        return response()->json([
            'status' => true,
            'order'  => [
                'id'       => $order['id'],
                'amount'   => $order['amount'],
                'currency' => $order['currency'],
            ],
        ]);
    }

    /**
     * Verify a Razorpay payment (called by the browser after checkout).
     */
    public function verify(Request $request): JsonResponse
    {
        $data = $request->validate([
            'invoice_id'          => ['required', 'integer', 'exists:invoices,id'],
            'razorpay_order_id'   => ['required', 'string', 'max:100'],
            'razorpay_payment_id' => ['required', 'string', 'max:100'],
            'razorpay_signature'  => ['required', 'string', 'max:255'],
        ]);

        $invoice = Invoice::with('booking.guest')->findOrFail($data['invoice_id']);

        $this->authorizeInvoiceOwner($invoice);

        try {
            $api = $this->razorpay();

            // 1. Signature
            $api->utility->verifyPaymentSignature([
                'razorpay_order_id'   => $data['razorpay_order_id'],
                'razorpay_payment_id' => $data['razorpay_payment_id'],
                'razorpay_signature'  => $data['razorpay_signature'],
            ]);

            // 2. Amount aur invoice Razorpay se lo, client par bharosa nahi
            $rzpPayment = $api->payment->fetch($data['razorpay_payment_id']);
            $rzpOrder   = $api->order->fetch($data['razorpay_order_id']);

            $orderInvoiceId = (string) ($rzpOrder['notes']['invoice_id'] ?? '');

            if (
                ($rzpPayment['order_id'] ?? null) !== $data['razorpay_order_id']
                || !in_array($rzpPayment['status'] ?? '', ['captured', 'authorized'], true)
                || $orderInvoiceId !== (string) $invoice->id
            ) {
                throw new \RuntimeException('Payment details do not match this invoice.');
            }

            $amount = round(((int) $rzpPayment['amount']) / 100, 2);

            // 3. Save (invoice row lock ke saath)
            $outcome = DB::transaction(function () use ($invoice, $data, $amount) {
                $locked = Invoice::with('booking')
                    ->whereKey($invoice->id)
                    ->lockForUpdate()
                    ->firstOrFail();

                if (Payment::where('transaction_id', $data['razorpay_payment_id'])->exists()) {
                    return 'duplicate';
                }

                $remaining = $this->remaining($locked);

                if ($remaining <= 0) {
                    return 'settled';
                }

                if ($amount > $remaining + 0.01) {
                    throw new \RuntimeException('Amount cannot exceed remaining balance.');
                }

                Payment::create([
                    'invoice_id'     => $locked->id,
                    'payment_date'   => now(),
                    'amount'         => $amount,
                    'payment_method' => 'Razorpay',
                    'payment_status' => 'Paid',
                    'transaction_id' => $data['razorpay_payment_id'],
                    'remarks'        => 'Paid via Razorpay',
                    'status'         => 1,
                ]);

                $paid   = round((float) $locked->paid_amount + $amount, 2);
                $status = $this->statusFor($locked, $paid);

                $locked->update([
                    'paid_amount'    => $paid,
                    'payment_status' => $status,
                ]);

                $this->redeemCouponIfNeeded($locked);

                if ($locked->booking) {
                    $locked->booking->update(['payment_status' => $status]);
                }

                return 'paid';
            });

            $invoice->refresh();

            if ($outcome === 'paid') {
                $this->afterPayment($invoice, $amount);
            }

            return response()->json([
                'status'   => true,
                'message'  => $outcome === 'paid'
                    ? 'Payment completed successfully.'
                    : 'Payment already recorded.',
                'redirect' => $invoice->payment_status === 'Paid'
                    ? route('invoice.show', $invoice->id)
                    : route('frontend.payment.create', $invoice->id),
            ]);

        } catch (SignatureVerificationError $e) {
            $this->activityLog->log('Payment', 'Verification Failed', 'Razorpay signature verification failed.');

            return response()->json([
                'status'  => false,
                'message' => 'Payment verification failed.',
            ], 400);

        } catch (\Throwable $e) {
            // Razorpay se paisa kat gaya ho par DB fail hua ho to reconcile ke liye payment_id log mein rahegi.
            Log::error('Payment verification failed', [
                'invoice_id' => $invoice->id,
                'payment_id' => $data['razorpay_payment_id'],
                'message'    => $e->getMessage(),
            ]);

            $this->activityLog->log('Payment', 'Failed', 'Payment verification failed for Invoice #' . $invoice->id);

            return response()->json([
                'status'  => false,
                'message' => 'We could not confirm your payment. If money was deducted, please contact support.',
            ], 500);
        }
    }

    /* ---------------------------------------------------------
     | Helpers
     |--------------------------------------------------------- */

    private function razorpay(): Api
    {
        return new Api(
            config('services.razorpay.key'),
            config('services.razorpay.secret')
        );
    }

    private function remaining(Invoice $invoice): float
    {
        return round(
            ((float) $invoice->total_amount - (float) $invoice->discount) - (float) $invoice->paid_amount,
            2
        );
    }

    private function toPaise(float $amount): int
    {
        return (int) round($amount * 100);
    }

    private function statusFor(Invoice $invoice, float $paid): string
    {
        $payable = round((float) $invoice->total_amount - (float) $invoice->discount, 2);

        if ($paid >= $payable) {
            return 'Paid';
        }

        return $paid > 0 ? 'Partial' : 'Pending';
    }

    private function afterPayment(Invoice $invoice, float $amount): void
    {
        try {
            User::where('type', User::TYPE_ADMIN)->get()
                ->each(fn (User $admin) => $admin->notify(new PaymentNotification($invoice)));
        } catch (\Throwable $e) {
            report($e);
        }

        $who = optional(auth()->user())->name ?? 'guest';

        $this->activityLog->log(
            'Payment',
            $invoice->payment_status === 'Paid' ? 'Full Payment' : 'Partial Payment',
            'Invoice #' . $invoice->id . ' received Rs.' . $amount . ' via Razorpay from ' . $who
        );
    }

    private function redeemCouponIfNeeded(Invoice $invoice): void
    {
        if (!$invoice->coupon_id || $invoice->coupon_redeemed_at) {
            return;
        }

        $coupon = Coupon::query()->lockForUpdate()->find($invoice->coupon_id);

        if (!$coupon) {
            return;
        }

        $coupon->increment('used_count');
        $invoice->update(['coupon_redeemed_at' => now()]);
    }

    private function authorizeInvoiceOwner(Invoice $invoice): void
    {
        $invoice->loadMissing('booking.guest');

        $user = auth()->user();

        abort_unless(
            $user
            && $invoice->booking
            && $invoice->booking->guest
            && strcasecmp((string) $invoice->booking->guest->email, (string) $user->email) === 0,
            403
        );
    }

    /**
     * Cancelled / rejected booking ka payment nahi lena.
     */
    private function assertPayable(Invoice $invoice): void
    {
        abort_if(
            $invoice->booking
            && in_array($invoice->booking->booking_status, [
                Booking1::STATUS_CANCELLED,
                Booking1::STATUS_REJECTED,
            ], true),
            403,
            'This booking is no longer active.'
        );
    }
}