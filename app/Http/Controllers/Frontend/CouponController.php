<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Coupon;
use Illuminate\Http\Request;

class CouponController extends Controller
{
   public function apply(Request $request)
{
    $request->validate([
        'coupon_code' => 'required|string',
        'invoice_id' => 'required|exists:invoices,id',
    ]);

    $coupon = Coupon::where('code', strtoupper(trim($request->coupon_code)))->first();

    if (!$coupon) {
        return response()->json([
            'status' => false,
            'message' => 'Invalid coupon code.',
        ], 422);
    }

    if (!$coupon->isValid()) {
        return response()->json([
            'status' => false,
            'message' => 'This coupon is expired or inactive.',
        ], 422);
    }

    $invoice = \App\Models\Invoice::findOrFail($request->invoice_id);

    $remaining = $invoice->total_amount - $invoice->paid_amount;

    // Calculate discount
    if ($coupon->discount_type === 'percentage') {

        $discount = ($remaining * $coupon->discount_value) / 100;

        // Maximum discount limit
        if ($coupon->maximum_discount !== null) {
            $discount = min($discount, $coupon->maximum_discount);
        }

    } else {

        // Fixed discount
        $discount = $coupon->discount_value;
    }

    // Discount cannot be greater than remaining amount
    $discount = min($discount, $remaining);

    $finalAmount = $remaining - $discount;

    return response()->json([
        'status' => true,
        'message' => 'Coupon applied successfully.',

        'discount' => round($discount, 2),

        'final_amount' => round($finalAmount, 2),
    ]);
}
}