@extends('frontend.layouts.app')

@section('title', 'Reservation Details')

@section('content')

@push('after-styles')
<style>
    .reservation-detail-page {
        --detail-ink: #211d18;
        --detail-muted: #756d61;
        --detail-gold: #b58a30;
        --detail-line: #e7e1d7;
        min-height: calc(100vh - 84px);
        padding: 42px 0 72px;
        background: #f7f5f1;
        color: var(--detail-ink);
        font-family: 'Jost', sans-serif;
    }

    .detail-shell { width: min(1080px, calc(100% - 40px)); margin: 0 auto; }
    .detail-header { position: relative; padding: 27px 30px; border-left: 3px solid var(--detail-gold); background: #211d18; color: #fff; }
    .detail-eyebrow { color: var(--detail-gold); font-size: 11px; font-weight: 600; letter-spacing: 1.8px; text-transform: uppercase; }
    .detail-header h1 { margin: 6px 0 5px; color: #fff; font: 500 30px/1.2 'Playfair Display', serif; }
    .detail-header .subtext { color: #ded8ce; font-size: 13px; }
    .detail-card { padding: 24px; border: 1px solid var(--detail-line); border-top: 0; background: #fff; }
    .detail-grid { display: grid; grid-template-columns: repeat(3, minmax(0, 1fr)); gap: 12px; }
    .detail-item { min-width: 0; padding: 15px 16px; border: 1px solid var(--detail-line); background: #fcfbf8; }
    .detail-label { display: block; margin-bottom: 6px; color: var(--detail-muted); font-size: 10px; font-weight: 600; letter-spacing: 1.1px; text-transform: uppercase; }
    .detail-value { color: var(--detail-ink); font-size: 15px; font-weight: 600; overflow-wrap: anywhere; }
    .detail-item-amount .detail-value { color: #806016; font: 600 20px 'Playfair Display', serif; }
    .status-badge { display: inline-flex; align-items: center; justify-content: center; min-height: 28px; padding: 5px 9px; border: 1px solid transparent; border-radius: 2px; font-size: 10px; font-weight: 600; letter-spacing: .7px; text-transform: uppercase; }
    .badge-pending { border-color: #e7d5a8; background: #fbf7ed; color: #805d16; }
    .badge-confirmed { border-color: #bbd5bd; background: #f1f7f1; color: #426c47; }
    .badge-cancelled { border-color: #e4c1bb; background: #fbf2f0; color: #994a3d; }
    .badge-default { border-color: #d9d3ca; background: #f5f3ef; color: #625b51; }
    .detail-actions { display: flex; align-items: center; flex-wrap: wrap; gap: 10px; margin-top: 20px; padding-top: 18px; border-top: 1px solid var(--detail-line); }
    .btn-back, .btn-pay, .btn-cancel { display: inline-flex; min-height: 42px; align-items: center; justify-content: center; gap: 8px; padding: 10px 15px; border: 1px solid transparent; border-radius: 2px; font: 600 12px 'Jost', sans-serif; text-decoration: none; transition: background .18s ease, color .18s ease, border-color .18s ease; }
    .btn-back { border-color: #4f473c; background: #211d18; color: #fff; }
    .btn-back:hover { background: #393127; color: #fff; text-decoration: none; }
    .btn-pay { border-color: var(--detail-gold); background: var(--detail-gold); color: #211d18; }
    .btn-pay:hover { background: #c49a45; color: #211d18; text-decoration: none; }
    .btn-cancel { border-color: #d9b8b1; background: #fff; color: #994a3d; cursor: pointer; }
    .btn-cancel:hover { border-color: #994a3d; background: #fbf2f0; color: #823c31; }
    .invoice-note { margin: 0; padding: 12px 14px; border: 1px solid var(--detail-line); background: #fbfaf7; color: #625b51; font-size: 12px; }
    .invoice-note.success { border-color: #bbd5bd; background: #f1f7f1; color: #426c47; }
    .invoice-note.danger { border-color: #e7d5a8; background: #fbf7ed; color: #805d16; }

    @media (max-width: 800px) {
        .detail-grid { grid-template-columns: repeat(2, minmax(0, 1fr)); }
    }

    @media (max-width: 560px) {
        .reservation-detail-page { padding: 24px 0 48px; }
        .detail-shell { width: min(100% - 24px, 520px); }
        .detail-header { padding: 21px 18px; }
        .detail-header h1 { font-size: 25px; }
        .detail-card { padding: 15px; }
        .detail-grid { grid-template-columns: 1fr; gap: 9px; }
        .detail-actions { align-items: stretch; flex-direction: column; }
        .detail-actions > *, .detail-actions form, .detail-actions form button { width: 100%; }
    }
</style>
@endpush

<div class="reservation-detail-page">
    <div class="detail-shell">
        <div class="detail-header">
            <div class="detail-eyebrow">Hotel Luxura Palace · Your Stay</div>
            <h1>Reservation details</h1>
            <div class="subtext">Booking {{ $reservation->booking_no }} · Stay and payment information</div>
        </div>

        <div class="detail-card">
            <div class="detail-grid">
                <div class="detail-item">
                    <span class="detail-label">Booking No</span>
                    <div class="detail-value">{{ $reservation->booking_no }}</div>
                </div>

                <div class="detail-item">
                    <span class="detail-label">Room Number</span>
                    <div class="detail-value">{{ $reservation->room->room_number ?? '—' }}</div>
                </div>

                <div class="detail-item">
                    <span class="detail-label">Room Type</span>
                    <div class="detail-value">{{ $reservation->room->roomType->name ?? '—' }}</div>
                </div>

                <div class="detail-item">
                    <span class="detail-label">Floor</span>
                    <div class="detail-value">{{ $reservation->room->floor ?? '—' }}</div>
                </div>

                <div class="detail-item">
                    <span class="detail-label">Check In</span>
                    <div class="detail-value">{{ optional($reservation->check_in)->format('D, d M Y') ?? '—' }}</div>
                </div>

                <div class="detail-item">
                    <span class="detail-label">Check Out</span>
                    <div class="detail-value">{{ optional($reservation->check_out)->format('D, d M Y') ?? '—' }}</div>
                </div>

                <div class="detail-item">
                    <span class="detail-label">Adults</span>
                    <div class="detail-value">{{ $reservation->adults }}</div>
                </div>

                <div class="detail-item">
                    <span class="detail-label">Children</span>
                    <div class="detail-value">{{ $reservation->children }}</div>
                </div>

                <div class="detail-item detail-item-amount">
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

                @else
                    <div class="invoice-note danger">Your invoice will be available after checkout.</div>
                @endif

                @if(in_array($reservation->booking_status, ['Pending', 'Confirmed']))
                    <form action="{{ route('frontend.bookings.cancel', $reservation->id) }}" method="POST"
                          onsubmit="return confirm('Are you sure you want to cancel this booking?');">
                        @csrf
                        <button type="submit" class="btn-cancel">
                            <i class="fas fa-times-circle"></i> Cancel booking
                        </button>
                    </form>
                @endif
            </div>
        </div>
    </div>
</div>

@endsection