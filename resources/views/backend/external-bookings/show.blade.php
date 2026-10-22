@extends('backend.layouts.app')

@section('title', 'Dubai Booking Details')

@section('content')
    @include('includes.partials.messages')

    @php
        $status = strtolower($booking->status ?? 'pending');
        $paymentStatus = strtolower($booking->payment_status ?? 'unpaid');
    @endphp

    <div class="card shadow mb-4">

        <div class="card-header py-3 d-flex justify-content-between align-items-center flex-wrap">
            <h6 class="m-0 font-weight-bold text-primary">
                Dubai Booking Details
            </h6>

            <a href="{{ route('admin.bookings.external-bookings.index') }}"
               class="btn btn-secondary btn-sm">
                <i class="fas fa-arrow-left"></i> Back to Bookings
            </a>
        </div>

        <div class="card-body">

            {{-- Hotel Details --}}
            <div class="row">
                <div class="col-md-4 mb-4">
                    @if($booking->hotel_image)
                        <img
                            src="{{ $booking->hotel_image }}"
                            alt="{{ $booking->hotel_name }}"
                            class="img-fluid rounded"
                            style="width:100%; max-height:250px; object-fit:cover;"
                        >
                    @else
                        <div class="bg-light rounded d-flex align-items-center justify-content-center"
                             style="height:200px;">
                            <span class="text-muted">No hotel image available</span>
                        </div>
                    @endif
                </div>

                <div class="col-md-8">
                    <h4>{{ $booking->hotel_name }}</h4>

                    <p><strong>Booking Reference:</strong>
                        {{ $booking->booking_reference ?? 'N/A' }}</p>

                    <p><strong>Booking ID:</strong> {{ $booking->id }}</p>

                    <p><strong>User ID:</strong> {{ $booking->user_id }}</p>

                    <p><strong>Hotel ID:</strong> {{ $booking->hotel_id }}</p>
                </div>
            </div>

            <hr>

            {{-- Stay Details --}}
            <h6 class="font-weight-bold text-primary mb-3">Stay Details</h6>

            <div class="table-responsive">
                <table class="table table-bordered">
                    <tbody>
                        <tr>
                            <th style="width:30%">Check In Date</th>
                            <td>{{ $booking->check_in?->format('d M Y') }}</td>
                        </tr>
                        <tr>
                            <th>Check Out Date</th>
                            <td>{{ $booking->check_out?->format('d M Y') }}</td>
                        </tr>
                        <tr>
                            <th>Guests</th>
                            <td>{{ $booking->guests }}</td>
                        </tr>
                        <tr>
                            <th>Total Amount</th>
                            <td>
                                <strong>
                                    {{ $booking->currency }}
                                    {{ number_format((float) $booking->total_price, 2) }}
                                </strong>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>

            {{-- Booking and Payment Status --}}
            <h6 class="font-weight-bold text-primary mb-3 mt-4">
                Booking & Payment Status
            </h6>

            <div class="table-responsive">
                <table class="table table-bordered">
                    <tbody>
                        <tr>
                            <th style="width:30%">Booking Status</th>
                            <td>
                                @if($status === 'pending')
                                    <span class="badge badge-warning">Pending</span>
                                @elseif($status === 'confirmed')
                                    <span class="badge badge-success">Confirmed</span>
                                @elseif($status === 'checked_in')
                                    <span class="badge badge-primary">Checked In</span>
                                @elseif($status === 'checked_out')
                                    <span class="badge badge-info">Checked Out</span>
                                @else
                                    <span class="badge badge-secondary">
                                        {{ ucfirst(str_replace('_', ' ', $status)) }}
                                    </span>
                                @endif
                            </td>
                        </tr>

                        <tr>
                            <th>Payment Status</th>
                            <td>
                                @if($paymentStatus === 'paid')
                                    <span class="badge badge-success">Paid</span>
                                @else
                                    <span class="badge badge-warning">
                                        {{ ucfirst($paymentStatus) }}
                                    </span>
                                @endif
                            </td>
                        </tr>

                        <tr>
                            <th>Payment Method</th>
                            <td>{{ $booking->payment_method ?? 'N/A' }}</td>
                        </tr>

                        <tr>
                            <th>Razorpay Order ID</th>
                            <td>{{ $booking->razorpay_order_id ?? 'N/A' }}</td>
                        </tr>

                        <tr>
                            <th>Razorpay Payment ID</th>
                            <td>{{ $booking->razorpay_payment_id ?? 'N/A' }}</td>
                        </tr>

                        <tr>
                            <th>Paid At</th>
                            <td>{{ $booking->paid_at?->format('d M Y, h:i A') ?? 'N/A' }}</td>
                        </tr>

                        <tr>
                            <th>Created At</th>
                            <td>{{ $booking->created_at?->format('d M Y, h:i A') }}</td>
                        </tr>
                    </tbody>
                </table>
            </div>

            {{-- Admin Actions --}}
            <h6 class="font-weight-bold text-primary mb-3 mt-4">
                Booking Actions
            </h6>

            <div class="d-flex flex-wrap align-items-center" style="gap:10px;">

                @if($status === 'pending')
                    <form method="POST"
                          action="{{ route('admin.bookings.external-bookings.confirm', $booking->id) }}"
                          onsubmit="return confirm('Confirm this external booking? Verify the supplier reservation first.');">
                        @csrf
                        <button type="submit" class="btn btn-success">
                            <i class="fas fa-check"></i> Confirm Booking
                        </button>
                    </form>
                @endif

                @if($status === 'confirmed')
                    <form method="POST"
                          action="{{ route('admin.bookings.external-bookings.checkIn', $booking->id) }}"
                          onsubmit="return confirm('Record check-in for this booking?');">
                        @csrf
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-sign-in-alt"></i> Check In
                        </button>
                    </form>
                @endif

                @if($status === 'checked_in')
                    <form method="POST"
                          action="{{ route('admin.bookings.external-bookings.checkOut', $booking->id) }}"
                          onsubmit="return confirm('Complete check-out for this booking?');">
                        @csrf
                        <button type="submit" class="btn btn-warning">
                            <i class="fas fa-sign-out-alt"></i> Check Out
                        </button>
                    </form>
                @endif

                @if($status === 'checked_out' && $paymentStatus !== 'paid')
                    <span class="badge badge-info p-2">
                        Waiting for user payment
                    </span>
                @elseif($status === 'checked_out' && $paymentStatus === 'paid')
                    <span class="badge badge-success p-2">
                        Booking completed and paid
                    </span>
                @endif

                @if(!in_array($status, ['pending', 'confirmed', 'checked_in', 'checked_out']))
                    <span class="text-muted">
                        No actions available for this booking status.
                    </span>
                @endif

            </div>

            <div class="alert alert-info mt-4 mb-0">
                <strong>Important:</strong>
                Verify the supplier's reservation before confirming an external booking.
                Payment status is separate from booking status. After check-out,
                the user can proceed to payment from My Reservations.
            </div>

        </div>
    </div>
@endsection