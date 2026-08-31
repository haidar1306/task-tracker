@extends('frontend.layouts.app')

@section('content')
    @php
        $showPaymentSuccessPopup = $invoice->payment_status == 'Paid' && (
            request()->has('payment_success') ||
            request()->has('success') ||
            session()->has('flash_success') ||
            session()->has('status')
        );
    @endphp

    @if($showPaymentSuccessPopup)
        <div class="payment-success-overlay">
            <div class="payment-success-popup">
                <button type="button" class="payment-popup-close" aria-label="Close">×</button>

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
                    <div class="payment-popup-value">₹{{ number_format((float) $invoice->paid_amount, 2) }}</div>
                    <div class="payment-popup-meta">{{ now()->format('d-m-Y') }} • INV #{{ $invoice->invoice_no }}</div>
                </div>

                <div class="payment-popup-actions">
                    <a href="{{ route('frontend.invoice.show', $invoice->id) }}" class="btn btn-primary btn-continue">View Invoice</a>
                    <a href="{{ route('frontend.index') }}" class="btn btn-secondary btn-home">Go Home</a>
                </div>
            </div>
        </div>
    @endif

    <section class="hotel-section">
        <div class="container">
            <h2 class="hotel-title">Invoice Details</h2>

            <div class="hotel-card p-4 p-md-5 mb-4">
                <div class="row g-4">
                    <div class="col-lg-6">
                        <p class="mb-3"><strong>Invoice No:</strong> {{ $invoice->invoice_no }}</p>
                        <p class="mb-3"><strong>Booking ID:</strong> {{ $invoice->booking_id }}</p>
                        <p class="mb-3"><strong>Room Charge:</strong> ₹{{ $invoice->room_charge }}</p>
                        <p class="mb-3"><strong>Extra Charge:</strong> ₹{{ $invoice->extra_charge }}</p>
                        <p class="mb-3"><strong>Tax:</strong> ₹{{ $invoice->tax }}</p>
                        <p class="mb-3"><strong>Discount:</strong> ₹{{ $invoice->discount }}</p>
                    </div>

                    <div class="col-lg-6">
                        <div class="p-4 rounded bg-light border h-100">
                            <h4 class="mb-3">Payment Summary</h4>
                            <p class="mb-3"><strong>Total:</strong> ₹{{ $invoice->total_amount }}</p>
                            <p class="mb-3">
                                <strong>Payment Status:</strong>
                                @if($invoice->payment_status == 'Paid')
                                    <span class="badge badge-success">Paid</span>
                                @elseif($invoice->payment_status == 'Partial')
                                    <span class="badge badge-warning">Partial</span>
                                @else
                                    <span class="badge badge-danger">Pending</span>
                                @endif
                            </p>
                            <p class="mb-3"><strong>Paid Amount:</strong> ₹{{ number_format($invoice->paid_amount, 2) }}</p>
                            <p class="mb-0"><strong>Remaining Amount:</strong> ₹{{ number_format($invoice->total_amount - $invoice->paid_amount, 2) }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="hotel-card p-4 p-md-5">
                <h4 class="mb-4">Payment History</h4>

                <div class="table-responsive">
                    <table class="table mb-0 align-middle">
                        <thead>
                        <tr>
                            <th>Date & Time</th>
                            <th>Method</th>
                            <th>Amount</th>
                            <th>Status</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($invoice->payments as $payment)
                            <tr>
                                <td>{{ $payment->created_at->format('d M Y, h:i A') }}</td>
                                <td>{{ $payment->payment_method }}</td>
                                <td>₹{{ $payment->amount }}</td>
                                <td>
                                    <span class="badge badge-success">{{ $payment->payment_status }}</span>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </section>

    @if($showPaymentSuccessPopup)
        <style>
            .payment-success-overlay {
                position: fixed;
                inset: 0;
                display: flex;
                align-items: center;
                justify-content: center;
                background: rgba(38, 46, 58, 0.38);
                z-index: 1050;
                padding: 20px;
            }

            .payment-success-popup {
                position: relative;
                width: min(520px, calc(100vw - 36px));
                background: #fdfdfd;
                border-radius: 18px;
                box-shadow: 0 24px 50px rgba(15, 23, 42, 0.2);
                padding: 28px 28px 18px;
                text-align: center;
                border: 1px solid rgba(15, 23, 42, 0.06);
            }

            .payment-popup-close {
                position: absolute;
                top: 14px;
                right: 16px;
                border: none;
                background: transparent;
                font-size: 30px;
                line-height: 1;
                color: #4b5563;
                cursor: pointer;
            }

            .payment-popup-icon {
                width: 86px;
                height: 86px;
                margin: 8px auto 18px;
                display: flex;
                align-items: center;
                justify-content: center;
            }

            .payment-popup-icon svg {
                width: 86px;
                height: 86px;
                display: block;
            }

            .payment-success-popup h4 {
                margin: 0;
                font-size: 27px;
                font-weight: 800;
                color: #111827;
            }

            .payment-popup-message {
                margin: 12px 0 16px;
                font-size: 14px;
                color: #4b5563;
                line-height: 1.5;
            }

            .payment-popup-amount-block {
                margin: 0 auto 18px;
                width: 100%;
                max-width: 290px;
                background: #f8fafc;
                border-radius: 12px;
                padding: 14px 12px 10px;
                text-align: center;
                border: 1px solid rgba(148, 163, 184, 0.2);
            }

            .payment-popup-label {
                font-size: 12px;
                color: #6b7280;
                margin-bottom: 6px;
            }

            .payment-popup-value {
                font-size: 26px;
                font-weight: 800;
                color: #111827;
                letter-spacing: -0.03em;
                margin-bottom: 5px;
            }

            .payment-popup-meta {
                font-size: 11px;
                color: #6b7280;
            }

            .payment-popup-actions {
                display: flex;
                justify-content: center;
                gap: 12px;
                margin-top: 8px;
                flex-wrap: wrap;
            }

            .payment-popup-actions .btn {
                min-width: 180px;
                border-radius: 10px;
                padding: 12px 18px;
                font-size: 16px;
                font-weight: 600;
                border: 1px solid #d1d5db;
                text-decoration: none;
                display: inline-flex;
                align-items: center;
                justify-content: center;
            }

            .btn-continue {
                background: #d4af37;
                border-color: #d4af37;
                color: #fff;
            }

            .btn-continue:hover {
                background: #b8921f;
                border-color: #b8921f;
                color: #fff;
            }

            .btn-home {
                background: #fff;
                color: #111827;
            }

            @media (max-width: 480px) {
                .payment-popup-actions {
                    flex-direction: column;
                }

                .payment-popup-actions .btn {
                    width: 100%;
                }
            }
        </style>

        <script>
            document.addEventListener('DOMContentLoaded', function () {
                var toastEls = document.querySelectorAll('.global-toast');
                toastEls.forEach(function (toast) {
                    toast.remove();
                });

                var closeBtn = document.querySelector('.payment-popup-close');
                if (closeBtn) {
                    closeBtn.addEventListener('click', function () {
                        var overlay = document.querySelector('.payment-success-overlay');
                        if (overlay) {
                            overlay.remove();
                        }
                    });
                }
            });
        </script>
    @endif
@endsection
