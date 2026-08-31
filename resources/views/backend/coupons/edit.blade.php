@extends('backend.layouts.app')

@section('title', 'Edit Coupon')

@section('content')
<div class="container-fluid">

    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h3 mb-1">Edit Coupon</h1>
            <p class="text-muted mb-0">Update coupon details</p>
        </div>

        <a href="{{ route('admin.coupons.index') }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left"></i> Back
        </a>
    </div>

    @if ($errors->any())
        <div class="alert alert-danger">
            <strong>Please fix the following errors:</strong>

            <ul class="mb-0 mt-2">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="card shadow-sm">

        <div class="card-header">
            <h6 class="m-0 font-weight-bold">
                Edit Coupon
            </h6>
        </div>

        <div class="card-body">

            <form action="{{ route('admin.coupons.update', $coupon) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="row">

                    {{-- Coupon Code --}}
                    <div class="col-md-6 mb-3">
                        <label for="code">
                            Coupon Code <span class="text-danger">*</span>
                        </label>

                        <input type="text"
                               name="code"
                               id="code"
                               class="form-control"
                               value="{{ old('code', $coupon->code) }}"
                               style="text-transform: uppercase;"
                               required>
                    </div>

                    {{-- Discount Type --}}
                    <div class="col-md-3 mb-3">
                        <label for="discount_type">
                            Discount Type <span class="text-danger">*</span>
                        </label>

                        <select name="discount_type"
                                id="discount_type"
                                class="form-control"
                                required>

                            <option value="percentage"
                                {{ old('discount_type', $coupon->discount_type) == 'percentage' ? 'selected' : '' }}>
                                Percentage (%)
                            </option>

                            <option value="fixed"
                                {{ old('discount_type', $coupon->discount_type) == 'fixed' ? 'selected' : '' }}>
                                Fixed Amount (₹)
                            </option>

                        </select>
                    </div>

                    {{-- Discount Value --}}
                    <div class="col-md-3 mb-3">
                        <label for="discount_value">
                            Discount Value <span class="text-danger">*</span>
                        </label>

                        <input type="number"
                               name="discount_value"
                               id="discount_value"
                               class="form-control"
                               value="{{ old('discount_value', $coupon->discount_value) }}"
                               min="0"
                               step="0.01"
                               required>
                    </div>

                    {{-- Minimum Amount --}}
                    <div class="col-md-4 mb-3">
                        <label for="minimum_amount">
                            Minimum Booking Amount
                        </label>

                        <input type="number"
                               name="minimum_amount"
                               id="minimum_amount"
                               class="form-control"
                               value="{{ old('minimum_amount', $coupon->minimum_amount) }}"
                               min="0"
                               step="0.01">
                    </div>

                    {{-- Maximum Discount --}}
                    <div class="col-md-4 mb-3">
                        <label for="maximum_discount">
                            Maximum Discount
                        </label>

                        <input type="number"
                               name="maximum_discount"
                               id="maximum_discount"
                               class="form-control"
                               value="{{ old('maximum_discount', $coupon->maximum_discount) }}"
                               min="0"
                               step="0.01">

                        <small class="text-muted">
                            Leave empty for unlimited.
                        </small>
                    </div>

                    {{-- Usage Limit --}}
                    <div class="col-md-4 mb-3">
                        <label for="usage_limit">
                            Usage Limit
                        </label>

                        <input type="number"
                               name="usage_limit"
                               id="usage_limit"
                               class="form-control"
                               value="{{ old('usage_limit', $coupon->usage_limit) }}"
                               min="1">

                        <small class="text-muted">
                            Leave empty for unlimited.
                        </small>
                    </div>

                    {{-- Start Date --}}
                    <div class="col-md-6 mb-3">
                        <label for="starts_at">
                            Start Date & Time
                        </label>

                        <input type="datetime-local"
                               name="starts_at"
                               id="starts_at"
                               class="form-control"
                               value="{{ old('starts_at', $coupon->starts_at ? $coupon->starts_at->format('Y-m-d\TH:i') : '') }}">
                    </div>

                    {{-- Expiry Date --}}
                    <div class="col-md-6 mb-3">
                        <label for="expires_at">
                            Expiry Date & Time
                        </label>

                        <input type="datetime-local"
                               name="expires_at"
                               id="expires_at"
                               class="form-control"
                               value="{{ old('expires_at', $coupon->expires_at ? $coupon->expires_at->format('Y-m-d\TH:i') : '') }}">
                    </div>

                    {{-- Description --}}
                    <div class="col-md-12 mb-3">
                        <label for="description">
                            Description
                        </label>

                        <textarea name="description"
                                  id="description"
                                  rows="4"
                                  class="form-control">{{ old('description', $coupon->description) }}</textarea>
                    </div>

                    {{-- Status --}}
                    <div class="col-md-12 mb-3">

                        <div class="custom-control custom-switch">

                            <input type="checkbox"
                                   name="status"
                                   value="1"
                                   class="custom-control-input"
                                   id="status"
                                   {{ old('status', $coupon->status) ? 'checked' : '' }}>

                            <label class="custom-control-label" for="status">
                                Active Coupon
                            </label>

                        </div>

                    </div>

                </div>

                <hr>

                <div class="d-flex justify-content-end">

                    <a href="{{ route('admin.coupons.index') }}"
                       class="btn btn-secondary mr-2">
                        Cancel
                    </a>

                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save"></i>
                        Update Coupon
                    </button>

                </div>

            </form>

        </div>
    </div>

</div>
@endsection