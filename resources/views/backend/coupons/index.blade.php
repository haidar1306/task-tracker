@extends('backend.layouts.app')

@section('title', 'Coupons')

@section('content')
<div class="container-fluid">

    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h3 mb-1">Coupons</h1>
            <p class="text-muted mb-0">Manage discount coupons</p>
        </div>

        <a href="{{ route('admin.coupons.create') }}" class="btn btn-primary">
            <i class="fas fa-plus"></i> Add Coupon
        </a>
    </div>

    @if(session('flash_success'))
        <div class="alert alert-success">
            {{ session('flash_success') }}
        </div>
    @endif

    <div class="card">
        <div class="card-header">
            <h6 class="m-0 font-weight-bold">All Coupons</h6>
        </div>

        <div class="card-body">

            <div class="table-responsive">
                <table class="table table-bordered table-hover">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Code</th>
                            <th>Discount</th>
                            <th>Minimum Amount</th>
                            <th>Validity</th>
                            <th>Usage</th>
                            <th>Status</th>
                            <th width="150">Action</th>
                        </tr>
                    </thead>

                    <tbody>
                        @forelse($coupons as $coupon)
                            <tr>
                                <td>{{ $loop->iteration }}</td>

                                <td>
                                    <strong>{{ $coupon->code }}</strong>
                                </td>

                                <td>
                                    @if($coupon->discount_type === 'percentage')
                                        {{ $coupon->discount_value }}%
                                    @else
                                        ₹{{ number_format($coupon->discount_value, 2) }}
                                    @endif
                                </td>

                                <td>
                                    ₹{{ number_format($coupon->minimum_amount, 2) }}
                                </td>

                                <td>
                                    @if($coupon->starts_at)
                                        {{ $coupon->starts_at->format('d M Y') }}
                                    @else
                                        -
                                    @endif

                                    <br>

                                    <small class="text-muted">
                                        to
                                        {{ $coupon->expires_at
                                            ? $coupon->expires_at->format('d M Y')
                                            : 'No expiry'
                                        }}
                                    </small>
                                </td>

                                <td>
                                    {{ $coupon->used_count }}

                                    @if($coupon->usage_limit)
                                        / {{ $coupon->usage_limit }}
                                    @else
                                        / Unlimited
                                    @endif
                                </td>

                                <td>
                                    @if($coupon->status)
                                        <span class="badge badge-success">
                                            Active
                                        </span>
                                    @else
                                        <span class="badge badge-secondary">
                                            Inactive
                                        </span>
                                    @endif
                                </td>

                                <td>
                                    <a href="{{ route('admin.coupons.edit', $coupon) }}"
                                       class="btn btn-sm btn-info">
                                        Edit
                                    </a>

                                    <form action="{{ route('admin.coupons.destroy', $coupon) }}"
                                          method="POST"
                                          class="d-inline"
                                          onsubmit="return confirm('Are you sure you want to delete this coupon?');">
                                        @csrf
                                        @method('DELETE')

                                        <button type="submit"
                                                class="btn btn-sm btn-danger">
                                            Delete
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8" class="text-center">
                                    No coupons found.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="mt-3">
                {{ $coupons->links() }}
            </div>

        </div>
    </div>

</div>
@endsection