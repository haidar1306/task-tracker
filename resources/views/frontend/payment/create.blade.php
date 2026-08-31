@extends('frontend.layouts.app')

@section('content')

    @if(request()->has('success') && request()->get('partial') == 1)
        <div class="payment-success-overlay">
            <div class="payment-success-popup">
                <!-- <button type="button" class="payment-popup-close" aria-label="Close">×</button> -->

                <div class="payment-popup-icon">
                    <svg viewBox="0 0 64 64" aria-hidden="true">
                        <rect x="12" y="22" width="36" height="28" rx="5" fill="#1e88e5"></rect>
                        <rect x="18" y="16" width="24" height="10" rx="3" fill="#1e88e5"></rect>
                        <path d="M22 30h18M22 36h14" stroke="#ffffff" stroke-width="2.5" stroke-linecap="round"></path>
                        <path d="M26 14l10 10" stroke="#1e88e5" stroke-width="3" stroke-linecap="round"></path>
                        <path d="M36 14l-10 10" stroke="#1e88e5" stroke-width="3" stroke-linecap="round"></path>
                    </svg>
                </div>

                <h4>Payment Successful!</h4>
                <p class="payment-popup-message">Payment successful! Your transaction has been processed smoothly.</p>

                <div class="payment-popup-amount-block">
                    <div class="payment-popup-label">Amount</div>
                    <div class="payment-popup-value">₹{{ number_format((float) request('amount'), 2) }}</div>
                    <div class="payment-popup-meta">08-01-2025 • INV #{{ $invoice->invoice_no }}</div>
                </div>

                <div class="payment-popup-actions">
                    <a href="{{ route('frontend.payment.create', $invoice->id) }}"
                        class="btn btn-primary btn-continue">Remaining Payment</a>
                    <a href="{{ route('frontend.index') }}" class="btn btn-secondary btn-home">Go Home</a>
                </div>
            </div>
        </div>
    @endif

    <div class="container py-5">

        @php
            $remaining = $invoice->total_amount - $invoice->paid_amount;
        @endphp

        <h2>Payment</h2>

        <p>
            <strong>Invoice No :</strong>
            {{ $invoice->invoice_no }}
        </p>

        <div class="row mb-4">
            <div id="couponSummary" class="mb-4" style="display: none;">

                <div class="alert alert-success">

                    <div class="d-flex justify-content-between">
                        <span>Coupon Discount</span>

                        <strong id="couponDiscount">
                            ₹0.00
                        </strong>
                    </div>

                    <div class="d-flex justify-content-between mt-2">
                        <span>Payable Amount</span>

                        <strong id="couponFinalAmount">
                            ₹0.00
                        </strong>
                    </div>

                </div>

            </div>

            <div class="col-md-4">
                <div class="alert alert-primary">
                    <strong>Total Amount</strong><br>
                    ₹{{ number_format($invoice->total_amount, 2) }}
                </div>
            </div>

            <div class="col-md-4">
                <div class="alert alert-success">
                    <strong>Paid Amount</strong><br>
                    ₹{{ number_format($invoice->paid_amount, 2) }}
                </div>
            </div>

            <div class="col-md-4">
                <div class="alert alert-danger">
                    <strong>Remaining Amount</strong><br>
                    ₹{{ number_format($remaining, 2) }}
                </div>
            </div>

        </div>

        @if($remaining > 0)
            @if($invoice->payment_status != 'Paid')
                @if($errors->any())
                    <div class="alert alert-danger">
                        <ul class="mb-0">
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form action="{{ route('frontend.payment.store', $invoice) }}" method="POST">

                    @csrf
                    <div class="coupon-box mt-3 mb-4">
                        <label for="coupon_code">
                            Have a Coupon?
                        </label>

                        <div class="input-group">
                            <input type="text" id="coupon_code" class="form-control" placeholder="Enter coupon code"
                                autocomplete="off">

                            <button type="button" id="applyCoupon" class="btn btn-primary">
                                Apply
                            </button>
                        </div>

                        <small id="couponMessage" class="d-block mt-2"></small>
                    </div>


                    <div class="form-group">
                        <label>Enter Amount</label>

                        <input type="number" id="payment_amount" name="amount" class="form-control" placeholder="Enter Amount"
                            min="1" max="{{ $remaining }}" required>
                        <small class="text-muted">
                            Maximum payable amount: ₹{{ number_format($remaining, 2) }}
                        </small>
                    </div>

                    <div class="form-group mt-3">
                        <label>Payment Method</label>

                        <select name="payment_method" class="form-control">

                            <option value="Cash">Cash</option>
                            <option value="UPI">UPI</option>
                            <option value="Card">Card</option>

                        </select>
                    </div>

                    <button type="button" id="rzp-button1" class="btn btn-primary">
                        Pay Now
                    </button>
                </form>

            @else

                <div class="alert alert-success">

                    <h4 class="mb-2">
                        ✅ Payment Completed Successfully
                    </h4>

                    <p class="mb-0">
                        This invoice has already been paid.
                    </p>

                </div>

                <a href="{{ route('frontend.invoice.show', $invoice) }}" class="btn btn-success">

                    View Invoice

                </a>

            @endif
        @endif

    </div>


@endsection
@push('after-scripts')


    <script src="https://checkout.razorpay.com/v1/checkout.js"></script>

    <script>

        const payButton = document.getElementById("rzp-button1");

        payButton.addEventListener("click", function (e) {

            e.preventDefault();

            let amount = $('#payment_amount').val();

            if (!amount || amount <= 0) {
                alert("Please enter amount first");
                return;
            }

            if (payButton.disabled) {
                return;
            }

            payButton.disabled = true;
            payButton.innerHTML = "Creating Order...";

            $.ajax({

                url: "{{ route('frontend.payment.create-order') }}",
                type: "POST",
                dataType: "json",

                data: {
                    _token: "{{ csrf_token() }}",
                    invoice_id: "{{ $invoice->id }}",
                    amount: amount
                },

                success: function (res) {

                    if (!res.status) {

                        alert(res.message);

                        payButton.disabled = false;
                        payButton.innerHTML = "Pay Now";

                        return;
                    }

                    var options = {

                        key: "{{ env('RAZORPAY_KEY') }}",

                        amount: res.order.amount,

                        currency: res.order.currency,

                        name: "Hotel Booking",

                        description: "Invoice Payment",

                        order_id: res.order.id,

                        handler: function (response) {

                            $.ajax({

                                url: "{{ route('frontend.payment.verify') }}",

                                type: "POST",

                                dataType: "json",

                                data: {

                                    _token: "{{ csrf_token() }}",

                                    invoice_id: "{{ $invoice->id }}",

                                    amount: $('#payment_amount').val(),

                                    razorpay_payment_id: response.razorpay_payment_id,

                                    razorpay_order_id: response.razorpay_order_id,

                                    razorpay_signature: response.razorpay_signature

                                },

                                success: function (res) {

                                    if (res.status) {

                                        let query = '?success=' + encodeURIComponent(res.message);

                                        if (res.redirect && res.redirect.includes('/payment/')) {
                                            query += '&partial=1&amount=' + encodeURIComponent($('#payment_amount').val());
                                        } else {
                                            query += '&payment_success=1';
                                        }

                                        window.location.href = res.redirect + query;

                                    } else {

                                        alert(res.message);

                                        payButton.disabled = false;
                                        payButton.innerHTML = "Pay Now";

                                    }

                                },

                                error: function (xhr) {

                                    console.log(xhr);

                                    alert(xhr.responseJSON?.message ?? "Payment verification failed.");

                                    payButton.disabled = false;
                                    payButton.innerHTML = "Pay Now";

                                }

                            });

                        },

                        modal: {

                            ondismiss: function () {

                                payButton.disabled = false;
                                payButton.innerHTML = "Pay Now";

                            }

                        },

                        prefill: {

                            name: "{{ $invoice->booking->guest_name ?? '' }}",

                            email: "",

                            contact: ""

                        },

                        theme: {

                            color: "#3399cc"

                        }

                    };

                    let rzp = new Razorpay(options);

                    rzp.open();

                },

                error: function (xhr) {

                    console.log(xhr);

                    alert(xhr.responseJSON?.message ?? "Order creation failed.");

                    payButton.disabled = false;
                    payButton.innerHTML = "Pay Now";

                }

            });

        });

    </script>
    <script>

        $('#applyCoupon').on('click', function () {

            let couponCode = $('#coupon_code').val().trim();
            let button = $('#applyCoupon');
            let message = $('#couponMessage');

            if (!couponCode) {
                message
                    .removeClass('text-success')
                    .addClass('text-danger')
                    .text('Please enter a coupon code.');

                return;
            }

            button.prop('disabled', true).text('Applying...');

            $.ajax({

                url: "{{ route('frontend.coupon.apply') }}",

                type: "POST",

                dataType: "json",

                data: {
                    _token: "{{ csrf_token() }}",
                    coupon_code: couponCode,
                    invoice_id: "{{ $invoice->id }}"
                },

                success: function (res) {

                    if (res.status) {

                        message
                            .removeClass('text-danger')
                            .addClass('text-success')
                            .text(res.message);

                        $('#couponDiscount').text(
                            '₹' + Number(res.discount).toFixed(2)
                        );

                        $('#couponFinalAmount').text(
                            '₹' + Number(res.final_amount).toFixed(2)
                        );

                        $('#couponSummary').show();

                        // Update payment amount
                        $('#payment_amount').val(
                            Number(res.final_amount).toFixed(2)
                        );

                        $('#payment_amount').attr(
                            'max',
                            Number(res.final_amount).toFixed(2)
                        );

                    } else {

                        message
                            .removeClass('text-success')
                            .addClass('text-danger')
                            .text(res.message);

                        $('#couponSummary').hide();
                    }

                },

                error: function (xhr) {

                    let errorMessage = 'Unable to apply coupon.';

                    if (xhr.responseJSON && xhr.responseJSON.message) {
                        errorMessage = xhr.responseJSON.message;
                    }

                    message
                        .removeClass('text-success')
                        .addClass('text-danger')
                        .text(errorMessage);

                    $('#couponSummary').hide();
                },

                complete: function () {

                    button.prop('disabled', false).text('Apply');

                }

            });

        });

    </script>
@endpush