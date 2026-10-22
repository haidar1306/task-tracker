<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Coupon;
use App\Models\Invoice;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CouponController extends Controller
{
    public function apply(Request $request)
    {
        $validated = $request->validate([
            'coupon_code' => 'required|string|max:50',
            'invoice_id' => 'required|exists:invoices,id',
        ]);

        $invoice = Invoice::with('booking.guest')->findOrFail($validated['invoice_id']);

        abort_unless(
            $invoice->booking &&
            $invoice->booking->guest &&
            $invoice->booking->guest->email === $request->user()->email,
            403
        );

        $result = DB::transaction(function () use ($validated, $invoice) {
            $lockedInvoice = Invoice::query()->lockForUpdate()->findOrFail($invoice->id);
            $coupon = Coupon::query()
                ->where('code', strtoupper(trim($validated['coupon_code'])))
                ->lockForUpdate()
                ->first();

            if (!$coupon) {
                return ['status' => false, 'message' => 'Invalid coupon code.'];
            }

            if ($reason = $coupon->invalidReason()) {
                return ['status' => false, 'message' => $reason];
            }

            if ($lockedInvoice->payment_status === 'Paid') {
                return ['status' => false, 'message' => 'This invoice has already been paid.'];
            }

            $baseDiscount = max(
                0,
                (float) $lockedInvoice->discount - (float) $lockedInvoice->coupon_discount
            );
            $eligibleAmount = max(
                0,
                (float) $lockedInvoice->total_amount - $baseDiscount - (float) $lockedInvoice->paid_amount
            );

            if ($eligibleAmount <= 0) {
                return ['status' => false, 'message' => 'There is no remaining balance for this coupon.'];
            }

            if ((float) $coupon->minimum_amount > $eligibleAmount) {
                return [
                    'status' => false,
                    'message' => 'This coupon requires a minimum payment of ₹' . number_format($coupon->minimum_amount, 2) . '.',
                ];
            }

            if ($coupon->discount_type === 'percentage') {
                $couponDiscount = $eligibleAmount * ((float) $coupon->discount_value / 100);

                if ($coupon->maximum_discount !== null) {
                    $couponDiscount = min($couponDiscount, (float) $coupon->maximum_discount);
                }
            } else {
                $couponDiscount = (float) $coupon->discount_value;
            }

            $couponDiscount = round(min(max($couponDiscount, 0), $eligibleAmount), 2);
            $effectiveDiscount = round($baseDiscount + $couponDiscount, 2);
            $finalAmount = max(0, round(
                (float) $lockedInvoice->total_amount - $effectiveDiscount - (float) $lockedInvoice->paid_amount,
                2
            ));

            $lockedInvoice->update([
                'coupon_id' => $coupon->id,
                'coupon_discount' => $couponDiscount,
                'discount' => $effectiveDiscount,
            ]);

            $fullyDiscounted = $finalAmount <= 0;

            if ($fullyDiscounted) {
                $lockedInvoice->update([
                    'payment_status' => 'Paid',
                    'coupon_redeemed_at' => now(),
                ]);
                $coupon->increment('used_count');
                $lockedInvoice->booking->update([
                    'payment_status' => 'Paid',
                    'booking_status' => 'Confirmed',
                ]);
            }

            return [
                'status' => true,
                'message' => 'Coupon applied successfully.',
                'discount' => $couponDiscount,
                'final_amount' => $finalAmount,
                'fully_discounted' => $fullyDiscounted,
                'redirect' => $fullyDiscounted ? route('frontend.invoice.show', $lockedInvoice->id) : null,
            ];
        });

        return response()->json($result);
    }
}