@extends('frontend.layouts.app')

@section('title', 'Reservation Details')

@section('content')

<style>
    .reservation-detail-page {
        padding: 70px 0 90px;
        background: linear-gradient(180deg, #f8f5f2 0%, #f3f6f8 100%);
    }

    .detail-shell {
        max-width: 1100px;
        margin: 0 auto;
    }

    .detail-header {
        background: linear-gradient(135deg, #1d2a36 0%, #243b53 100%);
        color: #fff;
        border-radius: 24px 24px 0 0;
        padding: 28px 32px;
        box-shadow: 0 16px 40px rgba(15, 23, 42, 0.12);
    }

    .detail-header h2 {
        margin: 0;
        font-size: clamp(2rem, 3vw, 2.6rem);
        font-weight: 800;
    }

    .detail-header .subtext {
        margin-top: 8px;
        color: rgba(255,255,255,0.72);
        font-size: 0.98rem;
    }

    .detail-card {
        background: #fff;
        border: 1px solid rgba(15, 23, 42, 0.06);
        border-radius: 0 0 24px 24px;
        box-shadow: 0 22px 50px rgba(15, 23, 42, 0.08);
        padding: 28px 24px 20px;
    }

    .detail-grid {
        display: grid;
        grid-template-columns: repeat(2, minmax(0, 1fr));
        gap: 22px;
        margin-bottom: 22px;
    }

    .detail-item {
        background: #f9fafb;
        border: 1px solid rgba(15, 23, 42, 0.06);
        border-radius: 16px;
        padding: 18px 18px 16px;
    }

    .detail-label {
        display: block;
        font-size: 0.76rem;
        letter-spacing: 0.11em;
        text-transform: uppercase;
        color: #64748b;
        margin-bottom: 8px;
    }

    .detail-value {
        font-size: 1.08rem;
        font-weight: 700;
        color: #182334;
    }

    .status-badge {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        min-width: 110px;
        padding: 8px 12px;
        border-radius: 999px;
        font-size: 0.73rem;
        font-weight: 700;
        letter-spacing: 0.04em;
        text-transform: uppercase;
    }

    .badge-pending {
        background: rgba(245, 158, 11, 0.12);
        color: #b45309;
    }

    .badge-confirmed {
        background: rgba(16, 185, 129, 0.12);
        color: #047857;
    }

    .badge-cancelled {
        background: rgba(239, 68, 68, 0.12);
        color: #b91c1c;
    }

    .badge-default {
        background: rgba(148, 163, 184, 0.14);
        color: #475569;
    }

    .detail-actions {
        display: flex;
        flex-wrap: wrap;
        gap: 14px;
        margin-top: 22px;
        padding-top: 18px;
        border-top: 1px solid rgba(15, 23, 42, 0.06);
    }

    .btn-back,
    .btn-pay,
    .btn-cancel {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        border: none;
        border-radius: 12px;
        padding: 12px 22px;
        font-weight: 700;
        text-decoration: none;
        transition: all 0.2s ease;
    }

    .btn-back {
        background: #1d2a36;
        color: #fff;
    }

    .btn-back:hover {
        background: #141f2a;
        color: #fff;
        text-decoration: none;
    }

    .btn-pay {
        background: #d8a35a;
        color: #fff;
    }

    .btn-pay:hover {
        background: #c99445;
        color: #fff;
        text-decoration: none;
    }

    .btn-cancel {
        background: #ef4444;
        color: #fff;
    }

    .btn-cancel:hover {
        background: #dc2626;
        color: #fff;
        text-decoration: none;
    }

    .invoice-note {
        margin-top: 18px;
        background: #f5f3ef;
        border: 1px solid rgba(216, 163, 90, 0.25);
        border-radius: 14px;
        padding: 16px 18px;
        color: #3a4a5c;
        font-weight: 600;
    }

    .invoice-note.success {
        background: rgba(16, 185, 129, 0.08);
        border-color: rgba(16, 185, 129, 0.18);
        color: #0f766e;
    }

    .invoice-note.danger {
        background: rgba(239, 68, 68, 0.08);
        border-color: rgba(239, 68, 68, 0.16);
        color: #b91c1c;
    }

    @media (max-width: 768px) {
        .detail-grid {
            grid-template-columns: 1fr;
        }
    }
</style>

<div class="reservation-detail-page">
    <div class="detail-shell">
        <div class="detail-header">
            <h2>Reservation Details</h2>
            <div class="subtext">Everything related to this stay is listed below.</div>
        </div>

        <div class="detail-card">
            <div class="detail-grid">
                <div class="detail-item">
                    <span class="detail-label">Booking No</span>
                    <div class="detail-value">{{ $reservation->booking_no }}</div>
                </div>

                <div class="detail-item">
                    <span class="detail-label">Room Number</span>
                    <div class="detail-value">{{ $reservation->room->room_number }}</div>
                </div>

                <div class="detail-item">
                    <span class="detail-label">Room Type</span>
                    <div class="detail-value">{{ $reservation->room->roomType->name }}</div>
                </div>

                <div class="detail-item">
                    <span class="detail-label">Floor</span>
                    <div class="detail-value">{{ $reservation->room->floor }}</div>
                </div>

                <div class="detail-item">
                    <span class="detail-label">Check In</span>
                    <div class="detail-value">{{ $reservation->check_in }}</div>
                </div>

                <div class="detail-item">
                    <span class="detail-label">Check Out</span>
                    <div class="detail-value">{{ $reservation->check_out }}</div>
                </div>

                <div class="detail-item">
                    <span class="detail-label">Adults</span>
                    <div class="detail-value">{{ $reservation->adults }}</div>
                </div>

                <div class="detail-item">
                    <span class="detail-label">Children</span>
                    <div class="detail-value">{{ $reservation->children }}</div>
                </div>

                <div class="detail-item">
                    <span class="detail-label">Total Amount</span>
                    <div class="detail-value">₹{{ number_format($reservation->total_amount, 2) }}</div>
                </div>

                <div class="detail-item">
                    <span class="detail-label">Booking Status</span>
                    @if($reservation->booking_status == 'Pending')
                        <span class="status-badge badge-pending">Pending</span>
                    @elseif($reservation->booking_status == 'Confirmed')
                        <span class="status-badge badge-confirmed">Confirmed</span>
                    @elseif($reservation->booking_status == 'Cancelled')
                        <span class="status-badge badge-cancelled">Cancelled</span>
                    @else
                        <span class="status-badge badge-default">{{ $reservation->booking_status }}</span>
                    @endif
                </div>

                <div class="detail-item">
                    <span class="detail-label">Payment Status</span>
                    @if($reservation->payment_status == 'Pending')
                        <span class="status-badge badge-pending">Pending</span>
                    @elseif($reservation->payment_status == 'Paid')
                        <span class="status-badge badge-confirmed">Paid</span>
                    @else
                        <span class="status-badge badge-default">{{ $reservation->payment_status }}</span>
                    @endif
                </div>
            </div>

            <div class="detail-actions">
                <a href="{{ route('frontend.reservation.index') }}" class="btn-back">← Back to My Reservations</a>

                @if($reservation->invoice)
                    @if($reservation->invoice->payment_status !== 'Paid')
                        <a href="{{ route('frontend.payment.create', $reservation->invoice->id) }}" class="btn-pay">Pay Now</a>
                    @else
                        <div class="invoice-note success">Payment completed successfully.</div>
                    @endif

                    @if(in_array($reservation->booking_status, ['Pending', 'Confirmed']))
                        <form action="{{ route('frontend.bookings.cancel', $reservation->id) }}" method="POST"
                              onsubmit="return confirm('Are you sure you want to cancel this booking?');">
                            @csrf
                            <button type="submit" class="btn-cancel">
                                <i class="fas fa-times-circle"></i> Cancel Booking
                            </button>
                        </form>
                    @endif
                @else
                    <div class="invoice-note danger">Invoice not found.</div>
                @endif
            </div>
        </div>
    </div>
</div>

@endsection