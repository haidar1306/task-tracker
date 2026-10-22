@extends('frontend.layouts.app')

@section('title', 'Dubai Booking Payment')

@section('content')
<div class="container py-5" style="max-width: 900px;">
    <div class="card shadow-sm">
        <div class="card-header bg-dark text-white">
            <h4 class="mb-0">Complete Your Dubai Booking Payment</h4>
        </div>

        <div class="card-body">
            @if(session('error'))
                <div class="alert alert-danger">{{ session('error') }}</div>
            @endif

            <div class="row">
                @if($booking->hotel_image)
                    <div class="col-md-4 mb-3">
                        <img
                            src="{{ $booking->hotel_image }}"
                            alt="{{ $booking->hotel_name }}"
                            class="img-fluid rounded"
                        >
                    </div>
                @endif

                <div class="{{ $booking->hotel_image ? 'col-md-8' : 'col-12' }}">
                    <h5>{{ $booking->hotel_name }}</h5>

                    <p class="text-muted mb-2">
                        Booking reference:
                        <strong>{{ $booking->booking_reference ?? ('DB-' . $booking->id) }}</strong>
                    </p>

                    <table class="table table-bordered">
                        <tr>
                            <th>Check-in</th>
                            <td>{{ $booking->check_in->format('d M Y') }}</td>
                        </tr>
                        <tr>
                            <th>Check-out</th>
                            <td>{{ $booking->check_out->format('d M Y') }}</td>
                        </tr>
                        <tr>
                            <th>Guests</th>
                            <td>{{ $booking->guests }}</td>
                        </tr>
                        <tr>
                            <th>Total amount</th>
                            <td>
                                <strong>
                                    {{ $booking->currency }}
                                    {{ number_format((float) $booking->total_price, 2) }}
                                </strong>
                            </td>
                        </tr>
                        <tr>
                            <th>Payment status</th>
                            <td>
                                @if($booking->payment_status === 'paid')
                                    <span class="badge bg-success">Paid</span>
                                @else
                                    <span class="badge bg-warning text-dark">Unpaid</span>
                                @endif
                            </td>
                        </tr>
                    </table>

                    @if($booking->payment_status === 'paid')
                        <div class="alert alert-success">
                            Payment has already been verified for this booking.
                        </div>
                        <a href="{{ route('frontend.reservation.index') }}"
                           class="btn btn-outline-dark">
                            My Reservations
                        </a>
                    @else
                        <button type="button" id="payDubaiBooking" class="btn btn-dark btn-lg">
                            Pay Securely with Razorpay
                        </button>

                        <a href="{{ route('frontend.reservation.index') }}"
                           class="btn btn-outline-secondary btn-lg">
                            My Reservations
                        </a>

                        <p class="small text-muted mt-3 mb-0">
                            Your payment status updates only after server-side verification.
                            Payment does not itself confirm the reservation with the external hotel supplier.
                        </p>

                        <div id="paymentMessage" class="alert alert-danger mt-3 d-none"
                             role="alert"></div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@if($booking->payment_status !== 'paid')
    @push('after-scripts')
        <script src="https://checkout.razorpay.com/v1/checkout.js"></script>
        <script>
        document.addEventListener('DOMContentLoaded', function () {
            const button = document.getElementById('payDubaiBooking');
            const message = document.getElementById('paymentMessage');

            if (!button) return;

            const originalText = button.textContent;

            function showError(text) {
                message.textContent = text || 'Payment could not be completed. Please try again.';
                message.classList.remove('d-none');
            }

            function resetButton() {
                button.disabled = false;
                button.textContent = originalText;
            }

            button.addEventListener('click', async function () {
                if (button.disabled) return;

                button.disabled = true;
                button.textContent = 'Creating secure order...';
                message.classList.add('d-none');

                try {
                    const orderResponse = await fetch(
                        @json(route('frontend.dubai-booking.create-order', $booking->id)),
                        {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'Accept': 'application/json',
                                'X-CSRF-TOKEN': @json(csrf_token())
                            },
                            body: JSON.stringify({})
                        }
                    );

                    const orderData = await orderResponse.json();

                    if (!orderResponse.ok || !orderData.status) {
                        throw new Error(orderData.message || 'Unable to create payment order.');
                    }

                    const options = {
                        key: orderData.key,
                        amount: orderData.order.amount,
                        currency: orderData.order.currency,
                        name: 'Hotel Luxura Palace',
                        description: 'Dubai booking ' + orderData.booking.reference,
                        order_id: orderData.order.id,

                        handler: async function (response) {
                            button.textContent = 'Verifying payment...';

                            try {
                                const verifyResponse = await fetch(
                                    @json(route('frontend.dubai-booking.verify-payment', $booking->id)),
                                    {
                                        method: 'POST',
                                        headers: {
                                            'Content-Type': 'application/json',
                                            'Accept': 'application/json',
                                            'X-CSRF-TOKEN': @json(csrf_token())
                                        },
                                        body: JSON.stringify({
                                            razorpay_payment_id: response.razorpay_payment_id,
                                            razorpay_order_id: response.razorpay_order_id,
                                            razorpay_signature: response.razorpay_signature
                                        })
                                    }
                                );

                                const verification = await verifyResponse.json();

                                if (!verifyResponse.ok || !verification.status) {
                                    throw new Error(
                                        verification.message || 'Payment verification failed.'
                                    );
                                }

                                window.location.href = verification.redirect;
                            } catch (error) {
                                showError(error.message);
                                resetButton();
                            }
                        },

                        modal: {
                            ondismiss: function () {
                                resetButton();
                            }
                        },

                        theme: {
                            color: '#b58a30'
                        }
                    };

                    const razorpay = new Razorpay(options);

                    razorpay.on('payment.failed', function (response) {
                        showError(
                            response.error && response.error.description
                                ? response.error.description
                                : 'Payment failed. You can try again.'
                        );
                        resetButton();
                    });

                    razorpay.open();
                } catch (error) {
                    showError(error.message);
                    resetButton();
                }
            });
        });
        </script>
    @endpush
@endif