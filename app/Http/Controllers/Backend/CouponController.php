<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Coupon;
use Illuminate\Http\Request;

class CouponController extends Controller
{
    /**
     * Display all coupons.
     */
    public function index()
    {
        $coupons = Coupon::latest()->paginate(10);

        return view('backend.coupons.index', compact('coupons'));
    }

    /**
     * Show create coupon form.
     */
    public function create()
    {
        return view('backend.coupons.create');
    }

    /**
     * Store new coupon.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'code' => 'required|string|max:50|unique:coupons,code',
            'discount_type' => 'required|in:percentage,fixed',
            'discount_value' => 'required|numeric|min:0',
            'minimum_amount' => 'nullable|numeric|min:0',
            'maximum_discount' => 'nullable|numeric|min:0',
            'starts_at' => 'nullable|date',
            'expires_at' => 'nullable|date|after_or_equal:starts_at',
            'usage_limit' => 'nullable|integer|min:1',
            'status' => 'nullable|boolean',
            'description' => 'nullable|string',
        ]);

        $validated['code'] = strtoupper($validated['code']);
        $validated['status'] = $request->boolean('status');

        Coupon::create($validated);

        return redirect()
            ->route('admin.coupons.index')
            ->with('flash_success', 'Coupon created successfully.');
    }

    /**
     * Show edit coupon form.
     */
    public function edit(Coupon $coupon)
    {
        return view('backend.coupons.edit', compact('coupon'));
    }

    /**
     * Update coupon.
     */
    public function update(Request $request, Coupon $coupon)
    {
        $validated = $request->validate([
            'code' => 'required|string|max:50|unique:coupons,code,' . $coupon->id,
            'discount_type' => 'required|in:percentage,fixed',
            'discount_value' => 'required|numeric|min:0',
            'minimum_amount' => 'nullable|numeric|min:0',
            'maximum_discount' => 'nullable|numeric|min:0',
            'starts_at' => 'nullable|date',
            'expires_at' => 'nullable|date|after_or_equal:starts_at',
            'usage_limit' => 'nullable|integer|min:1',
            'status' => 'nullable|boolean',
            'description' => 'nullable|string',
        ]);

        $validated['code'] = strtoupper($validated['code']);
        $validated['status'] = $request->boolean('status');

        $coupon->update($validated);

        return redirect()
            ->route('admin.coupons.index')
            ->with('flash_success', 'Coupon updated successfully.');
    }

    /**
     * Delete coupon.
     */
    public function destroy(Coupon $coupon)
    {
        $coupon->delete();

        return redirect()
            ->route('admin.coupons.index')
            ->with('flash_success', 'Coupon deleted successfully.');
    }
}