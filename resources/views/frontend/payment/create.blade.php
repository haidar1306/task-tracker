@extends('frontend.layouts.app')
@section('navbar_mode', 'solid')


@section('title', 'Secure Payment')

@push('after-styles')
    <style>
        .payment-page {
            --payment-ink: #211d18;
            --payment-muted: #756d61;
            --payment-gold: #b58a30;
            --payment-line: #e7e1d7;
            min-height: calc(100vh - 84px);
            padding: 42px 0 72px;
            background: #f7f5f1;
            color: var(--payment-ink);
            font-family: 'Jost', sans-serif;
        }

        .payment-shell { width: min(1080px, calc(100% - 40px)); margin: 0 auto; }
        .payment-heading { display: flex; justify-content: space-between; align-items: flex-end; gap: 24px; margin-bottom: 24px; }
        .payment-eyebrow { color: var(--payment-gold); font-size: 11px; font-weight: 600; letter-spacing: 1.8px; text-transform: uppercase; }
        .payment-heading h1 { margin: 5px 0 6px; color: var(--payment-ink); font: 500 32px/1.15 'Playfair Display', serif; }
        .payment-heading p { margin: 0; color: var(--payment-muted); font-size: 14px; }
        .payment-invoice-tag { padding: 10px 13px; border: 1px solid #d8c9a8; color: #62502c; background: #fffdf8; font-size: 12px; white-space: nowrap; }
        .payment-layout { display: grid; grid-template-columns: minmax(0, .9fr) minmax(0, 1.1fr); gap: 20px; align-items: start; }
        .payment-panel { background: #fff; border: 1px solid var(--payment-line); }
        .payment-panel-heading { padding: 18px 21px; border-bottom: 1px solid var(--payment-line); }
        .payment-panel-heading h2 { margin: 0; color: var(--payment-ink); font: 500 20px 'Playfair Display', serif; }
        .payment-panel-heading p { margin: 5px 0 0; color: var(--payment-muted); font-size: 12px; }
        .payment-panel-body { padding: 20px; }
        .payment-stay { display: grid; grid-template-columns: 1fr 1fr; gap: 14px; padding-bottom: 17px; border-bottom: 1px solid var(--payment-line); }
        .payment-stay-label { display: block; color: var(--payment-muted); font-size: 11px; margin-bottom: 3px; }
        .payment-stay-value { color: var(--payment-ink); font-size: 14px; font-weight: 600; }
        .payment-breakdown { display: grid; gap: 12px; padding-top: 17px; }
        .payment-breakdown-row { display: flex; justify-content: space-between; gap: 16px; color: #5e574e; font-size: 13px; }
        .payment-breakdown-row strong { color: var(--payment-ink); font-weight: 600; }
        .payment-breakdown-row.total-due { padding-top: 12px; border-top: 1px solid var(--payment-line); color: var(--payment-ink); font-size: 15px; font-weight: 600; }
        .payment-breakdown-row.total-due strong { color: #806016; font-size: 18px; }
        .payment-form { display: grid; gap: 17px; }
        .payment-field label, .coupon-box label { display: block; color: var(--payment-ink); font-size: 12px; font-weight: 600; margin-bottom: 6px; }
        .payment-field input, .payment-field select, .coupon-box input { width: 100%; min-height: 44px; border: 1px solid #d8d1c5; border-radius: 2px; background: #fff; color: var(--payment-ink); padding: 9px 11px; font: 14px 'Jost', sans-serif; }
        .payment-field input:focus, .payment-field select:focus, .coupon-box input:focus { border-color: var(--payment-gold); outline: 2px solid rgba(181, 138, 48, .16); }
        .payment-help { display: block; margin-top: 5px; color: var(--payment-muted); font-size: 11px; }
        .coupon-box { padding: 14px; background: #fbfaf7; border: 1px solid var(--payment-line); }
        .coupon-box .input-group { display: flex; gap: 8px; }
        .coupon-box .input-group .form-control { min-width: 0; }
        .payment-apply, .payment-submit, .payment-secondary { display: inline-flex; min-height: 42px; align-items: center; justify-content: center; padding: 10px 16px; border: 1px solid var(--payment-gold); border-radius: 2px; font: 600 13px 'Jost', sans-serif; transition: background .18s ease, color .18s ease; }
        .payment-apply, .payment-submit { background: var(--payment-gold); color: #211d18; }
        .payment-apply:hover, .payment-submit:hover { background: #c49a45; color: #211d18; }
        .payment-submit { width: 100%; min-height: 48px; gap: 9px; }
        .payment-submit:disabled { opacity: .65; cursor: wait; }
        .payment-secondary { background: transparent; color: var(--payment-ink); text-decoration: none; }
        .payment-secondary:hover { background: #f3efe7; color: var(--payment-ink); text-decoration: none; }
        .payment-security { display: flex; align-items: flex-start; gap: 9px; color: var(--payment-muted); font-size: 11px; line-height: 1.5; }
        .payment-security i { color: var(--payment-gold); margin-top: 2px; }
        .payment-alert { padding: 13px 15px; border: 1px solid #e8c7bf; background: #fff8f6; color: #8f3c2f; font-size: 13px; }
        .payment-success-overlay { position: fixed; inset: 0; z-index: 1050; display: flex; align-items: center; justify-content: center; padding: 20px; background: rgba(24, 21, 17, .58); }
        .payment-success-popup { width: min(480px, 100%); padding: 28px; border: 1px solid var(--payment-line); background: #fff; box-shadow: 0 24px 60px rgba(0, 0, 0, .2); text-align: center; }
        .payment-popup-icon { color: #547d54; font-size: 36px; margin-bottom: 12px; }
        .payment-popup-icon svg { width: 52px; height: 52px; }
        .payment-success-popup h4 { color: var(--payment-ink); font: 500 24px 'Playfair Display', serif; margin: 0; }
        .payment-popup-message { color: var(--payment-muted); font-size: 13px; margin: 9px 0 16px; }
        .payment-popup-amount-block { padding: 14px; background: #f8f6f1; }
        .payment-popup-label, .payment-popup-meta { color: var(--payment-muted); font-size: 11px; }
        .payment-popup-value { color: var(--payment-ink); font: 600 23px 'Playfair Display', serif; padding: 4px 0; }
        .payment-popup-actions { display: flex; flex-wrap: wrap; justify-content: center; gap: 9px; margin-top: 18px; }
        .payment-popup-actions .btn { border-radius: 2px; }

        @media (max-width: 760px) {
            .payment-page { padding: 26px 0 48px; }
            .payment-shell { width: min(100% - 24px, 560px); }
            .payment-heading { align-items: flex-start; flex-direction: column; gap: 12px; }
            .payment-heading h1 { font-size: 27px; }
            .payment-layout { grid-template-columns: 1fr; }
        }

        @media (max-width: 420px) {
            .payment-stay { grid-template-columns: 1fr; }
            .payment-panel-body { padding: 16px; }
            .coupon-box .input-group { flex-direction: column; }
        }
    </style>
@endpush

@section('content')
    @php
        $booking = $invoice->booking;
        $room = $booking ? $booking->room : null;
        $roomType = $room ? $room->roomType : null;
        $discount = (float) ($invoice->discount ?? 0);
    @endphp

    @if(request()->has('success') && request()->get('partial') == 1)
        <div class="payment-success-overlay">
            <div class="payment-success-popup" role="dialog" aria-modal="true" aria-labelledby="payment-success-heading">
                <div class="payment-popup-icon" aria-hidden="true"><i class="fas fa-check-circle"></i></div>
                <h4 id="payment-success-heading">Payment successful</h4>
                <p class="payment-popup-message">Your payment has been processed and applied to this invoice.</p>
                <div class="payment-popup-amount-block">
                    <div class="payment-popup-label">Amount received</div>
                    <div class="payment-popup-value">₹{{ number_format((float) request('amount'), 2) }}</div>
                    <div class="payment-popup-meta">{{ now()->format('d M Y') }} · INV #{{ $invoice->invoice_no }}</div>
                </div>
                <div class="payment-popup-actions">
                    <a href="{{ route('frontend.payment.create', $invoice->id) }}" class="payment-apply">Remaining payment</a>
                    <a href="{{ route('frontend.index') }}" class="payment-secondary">Go home</a>
                </div>
            </div>
        </div>
    @endif

    <main class="payment-page">
        <div class="payment-shell">
            <header class="payment-heading">
                <div>
                    <div class="payment-eyebrow">Hotel Luxura Palace · Secure Checkout</div>
                    <h1>Complete your payment</h1>
                    <p>Review your invoice and choose an amount to pay securely.</p>
                </div>
                <div class="payment-invoice-tag">Invoice {{ $invoice->invoice_no }}</div>
            </header>

            <div class="payment-layout">
                <section class="payment-panel" aria-labelledby="payment-summary-title">
                    <div class="payment-panel-heading">
                        <h2 id="payment-summary-title">Stay and invoice summary</h2>
                        <p>{{ $booking->booking_no ?? 'Reservation details' }}</p>
                    </div>
                    <div class="payment-panel-body">
                        @if($booking)
                            <div class="payment-stay">
                                <div>
                                    <span class="payment-stay-label">Room</span>
                                    <span class="payment-stay-value">{{ $roomType->name ?? 'Room' }}{{ $room ? ' · ' . $room->room_number : '' }}</span>
                                </div>
                                <div>
                                    <span class="payment-stay-label">Stay dates</span>
                                    <span class="payment-stay-value">{{ optional($booking->check_in)->format('d M Y') }} – {{ optional($booking->check_out)->format('d M Y') }}</span>
                                </div>
                            </div>
                        @endif

                        <div class="payment-breakdown">
                            <div class="payment-breakdown-row">
                                <span>Invoice total</span>
                                <strong>₹{{ number_format((float) $invoice->total_amount, 2) }}</strong>
                            </div>
                            @if($discount > 0)
                                <div class="payment-breakdown-row">
                                    <span>Discount</span>
                                    <strong>− ₹{{ number_format($discount, 2) }}</strong>
                                </div>
                            @endif
                            <div class="payment-breakdown-row">
                                <span>Paid so far</span>
                                <strong>₹{{ number_format((float) $invoice->paid_amount, 2) }}</strong>
                            </div>
                            <div class="payment-breakdown-row total-due">
                                <span>Remaining due</span>
                                <strong>₹{{ number_format((float) $remaining, 2) }}</strong>
                            </div>
                        </div>
                    </div>
                </section>

                <section class="payment-panel" aria-labelledby="payment-action-title">
                    <div class="payment-panel-heading">
                        <h2 id="payment-action-title">Payment details</h2>
                        <p>Payments are processed through Razorpay secure checkout.</p>
                    </div>
                    <div class="payment-panel-body">
                        <div id="couponSummary" class="coupon-box mb-3" style="display: none;">
                            <div class="payment-breakdown-row">
                                <span>Coupon discount</span>
                                <strong id="couponDiscount">₹0.00</strong>
                            </div>
                            <div class="payment-breakdown-row mt-2">
                                <span>Payable amount</span>
                                <strong id="couponFinalAmount">₹0.00</strong>
                            </div>
                        </div>

                        @if($remaining > 0 && $invoice->payment_status != 'Paid')
                            @if($errors->any())
                                <div class="payment-alert mb-3" role="alert">
                                    <ul class="mb-0">
                                        @foreach($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif

                            <form action="{{ route('frontend.payment.store', $invoice) }}" method="POST" class="payment-form">
                                @csrf
                                <div class="coupon-box">
                                    <label for="coupon_code">Apply a coupon</label>
                                    <div class="input-group">
                                        <input type="text" id="coupon_code" class="form-control" placeholder="Enter coupon code" autocomplete="off">
                                        <button type="button" id="applyCoupon" class="payment-apply">Apply</button>
                                    </div>
                                    <small id="couponMessage" class="d-block mt-2" aria-live="polite"></small>
                                </div>

                                <div class="payment-field">
                                    <label for="payment_amount">Amount to pay</label>
                                    <input type="number" id="payment_amount" name="amount" class="form-control" placeholder="Enter amount" min="1" max="{{ $remaining }}" value="{{ old('amount', $remaining) }}" step="0.01" required>
                                    <small class="payment-help">Maximum payable now: ₹{{ number_format((float) $remaining, 2) }}</small>
                                </div>

                                <div class="payment-field">
                                    <label for="payment_method">Payment method</label>
                                    <select id="payment_method" name="payment_method" class="form-control">
                                        <option value="UPI">UPI</option>
                                        <option value="Card">Card</option>
                                        <option value="Cash">Cash</option>
                                    </select>
                                </div>

                                <button type="button" id="rzp-button1" class="payment-submit">
                                    <i class="fas fa-lock" aria-hidden="true"></i> Pay securely with Razorpay
                                </button>
                                <div class="payment-security">
                                    <i class="fas fa-shield-alt" aria-hidden="true"></i>
                                    <span>Your payment is encrypted and processed securely. Your invoice balance updates after verification.</span>
                                </div>
                            </form>
                        @else
                            <div class="payment-alert" role="status">This invoice has already been paid.</div>
                            <a href="{{ route('frontend.invoice.show', $invoice) }}" class="payment-secondary mt-3">View invoice</a>
                        @endif
                    </div>
                </section>
            </div>
        </div>
    </main>
@endsection

@push('after-scripts')
    <script src="https://checkout.razorpay.com/v1/checkout.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const payButton = document.getElementById('rzp-button1');

            if (payButton) {
                payButton.addEventListener('click', function (event) {
                    event.preventDefault();

                    const amount = $('#payment_amount').val();
                    if (!amount || amount <= 0) {
                        alert('Please enter amount first');
                        return;
                    }

                    if (payButton.disabled) return;

                    payButton.disabled = true;
                    payButton.innerHTML = 'Creating Order...';

                    $.ajax({
                        url: "{{ route('frontend.payment.create-order') }}",
                        type: 'POST',
                        dataType: 'json',
                        data: {
                            _token: "{{ csrf_token() }}",
                            invoice_id: "{{ $invoice->id }}",
                            amount: amount
                        },
                        success: function (res) {
                            if (!res.status) {
                                alert(res.message);
                                payButton.disabled = false;
                                payButton.innerHTML = '<i class="fas fa-lock" aria-hidden="true"></i> Pay securely with Razorpay';
                                return;
                            }

                            const options = {
                                key: "{{ env('RAZORPAY_KEY') }}",
                                amount: res.order.amount,
                                currency: res.order.currency,
                                name: 'Hotel Luxura Palace',
                                description: 'Invoice {{ $invoice->invoice_no }} payment',
                                order_id: res.order.id,
                                handler: function (response) {
                                    $.ajax({
                                        url: "{{ route('frontend.payment.verify') }}",
                                        type: 'POST',
                                        dataType: 'json',
                                        data: {
                                            _token: "{{ csrf_token() }}",
                                            invoice_id: "{{ $invoice->id }}",
                                            amount: $('#payment_amount').val(),
                                            razorpay_payment_id: response.razorpay_payment_id,
                                            razorpay_order_id: response.razorpay_order_id,
                                            razorpay_signature: response.razorpay_signature
                                        },
                                        success: function (verification) {
                                            if (verification.status) {
                                                let query = '?success=' + encodeURIComponent(verification.message);
                                                if (verification.redirect && verification.redirect.includes('/payment/')) {
                                                    query += '&partial=1&amount=' + encodeURIComponent($('#payment_amount').val());
                                                } else {
                                                    query += '&payment_success=1';
                                                }
                                                window.location.href = verification.redirect + query;
                                                return;
                                            }

                                            alert(verification.message);
                                            payButton.disabled = false;
                                            payButton.innerHTML = '<i class="fas fa-lock" aria-hidden="true"></i> Pay securely with Razorpay';
                                        },
                                        error: function (xhr) {
                                            alert(xhr.responseJSON?.message ?? 'Payment verification failed.');
                                            payButton.disabled = false;
                                            payButton.innerHTML = '<i class="fas fa-lock" aria-hidden="true"></i> Pay securely with Razorpay';
                                        }
                                    });
                                },
                                modal: {
                                    ondismiss: function () {
                                        payButton.disabled = false;
                                        payButton.innerHTML = '<i class="fas fa-lock" aria-hidden="true"></i> Pay securely with Razorpay';
                                    }
                                },
                                prefill: {
                                    name: @json($booking && $booking->guest ? $booking->guest->full_name : ''),
                                    email: @json($booking && $booking->guest ? $booking->guest->email : ''),
                                    contact: @json($booking && $booking->guest ? $booking->guest->phone : '')
                                },
                                theme: { color: '#b58a30' }
                            };

                            const razorpay = new Razorpay(options);
                            razorpay.open();
                        },
                        error: function (xhr) {
                            alert(xhr.responseJSON?.message ?? 'Order creation failed.');
                            payButton.disabled = false;
                            payButton.innerHTML = '<i class="fas fa-lock" aria-hidden="true"></i> Pay securely with Razorpay';
                        }
                    });
                });
            }

            $('#applyCoupon').on('click', function () {
                const couponCode = $('#coupon_code').val().trim();
                const button = $('#applyCoupon');
                const message = $('#couponMessage');

                if (!couponCode) {
                    message.removeClass('text-success').addClass('text-danger').text('Please enter a coupon code.');
                    return;
                }

                button.prop('disabled', true).text('Applying...');

                $.ajax({
                    url: "{{ route('frontend.coupon.apply') }}",
                    type: 'POST',
                    dataType: 'json',
                    data: {
                        _token: "{{ csrf_token() }}",
                        coupon_code: couponCode,
                        invoice_id: "{{ $invoice->id }}"
                    },
                    success: function (res) {
                        if (res.status) {
                            message.removeClass('text-danger').addClass('text-success').text(res.message);
                            $('#couponDiscount').text('₹' + Number(res.discount).toFixed(2));
                            $('#couponFinalAmount').text('₹' + Number(res.final_amount).toFixed(2));
                            $('#couponSummary').show();

                            if (res.fully_discounted && res.redirect) {
                                window.location.href = res.redirect;
                                return;
                            }

                            $('#payment_amount').val(Number(res.final_amount).toFixed(2));
                            $('#payment_amount').attr('max', Number(res.final_amount).toFixed(2));
                        } else {
                            message.removeClass('text-success').addClass('text-danger').text(res.message);
                            $('#couponSummary').hide();
                        }
                    },
                    error: function (xhr) {
                        const errorMessage = xhr.status === 429
                            ? 'Too many attempts. Please wait a minute before trying another coupon.'
                            : (xhr.responseJSON?.message ?? 'Unable to apply coupon.');
                        message.removeClass('text-success').addClass('text-danger').text(errorMessage);
                        $('#couponSummary').hide();
                    },
                    complete: function () {
                        button.prop('disabled', false).text('Apply');
                    }
                });
            });
        });
    </script>
@endpush