@extends('frontend.layouts.app')
@section('navbar_mode', 'solid')


@section('title', 'Reservation Details')

@push('after-styles')
<style>
    .rd-page {
        padding: 50px 0 90px;
        background: #f7f2ea;
        font-family: 'Jost', sans-serif;
        color: #2b2621;
    }

    .rd-shell {
        width: min(1120px, calc(100% - 40px));
        margin: 0 auto;
    }

    .rd-back {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        margin-bottom: 18px;
        color: #8a7f6f;
        font-size: 13px;
        font-weight: 600;
        text-decoration: none;
        transition: color .2s ease, transform .2s ease;
    }

    .rd-back:hover {
        color: #a9825c;
        text-decoration: none;
        transform: translateX(-3px);
    }

    /* Header */
    .rd-header {
        display: flex;
        align-items: flex-end;
        justify-content: space-between;
        flex-wrap: wrap;
        gap: 18px;
        margin-bottom: 26px;
    }

    .rd-kicker {
        display: block;
        margin-bottom: 8px;
        color: #a9825c;
        font-size: 11px;
        font-weight: 700;
        letter-spacing: 2px;
        text-transform: uppercase;
    }

    .rd-header h1 {
        margin: 0 0 6px;
        font-family: 'Playfair Display', serif;
        font-size: clamp(1.8rem, 3.5vw, 2.5rem);
        font-weight: 700;
    }

    .rd-header p {
        margin: 0;
        color: #8a7f6f;
        font-size: 14px;
    }

    .rd-badges {
        display: flex;
        flex-wrap: wrap;
        gap: 10px;
    }

    .rd-badge {
        display: inline-flex;
        align-items: center;
        gap: 7px;
        padding: 8px 14px;
        border-radius: 999px;
        font-size: 11px;
        font-weight: 700;
        letter-spacing: .8px;
        text-transform: uppercase;
        white-space: nowrap;
    }

    .rd-badge::before {
        content: "";
        width: 7px;
        height: 7px;
        border-radius: 50%;
        background: currentColor;
    }

    .b-pending   { background: #fdf6e7; color: #8f6a1f; }
    .b-confirmed { background: #eef7ee; color: #2e6b34; }
    .b-active    { background: #eaf2fb; color: #2f6aa8; }
    .b-cancelled { background: #fdecea; color: #b3261e; }
    .b-default   { background: #f1ede6; color: #6f665a; }

    /* Layout */
    .rd-layout {
        display: grid;
        grid-template-columns: minmax(0, 1fr) 340px;
        gap: 24px;
        align-items: start;
    }

    .rd-card {
        margin-bottom: 20px;
        padding: 26px 28px;
        background: #fffdfa;
        border: 1px solid #e5dccb;
        border-radius: 16px;
        box-shadow: 0 12px 30px rgba(43, 38, 33, .05);
    }

    .rd-card:last-child { margin-bottom: 0; }

    .rd-card-title {
        display: flex;
        align-items: center;
        gap: 10px;
        margin: 0 0 20px;
        font-family: 'Playfair Display', serif;
        font-size: 20px;
        font-weight: 700;
    }

    .rd-card-title i {
        color: #a9825c;
        font-size: 16px;
    }

    /* Stay timeline */
    .rd-stay {
        display: grid;
        grid-template-columns: 1fr auto 1fr;
        align-items: center;
        gap: 18px;
    }

    .rd-date-label {
        display: block;
        margin-bottom: 6px;
        color: #8a7f6f;
        font-size: 11px;
        font-weight: 700;
        letter-spacing: 1.4px;
        text-transform: uppercase;
    }

    .rd-date-big {
        font-family: 'Playfair Display', serif;
        font-size: 26px;
        font-weight: 700;
        line-height: 1.1;
    }

    .rd-date-sub {
        display: block;
        margin-top: 4px;
        color: #8a7f6f;
        font-size: 13px;
    }

    .rd-date.end { text-align: right; }

    .rd-nights {
        display: flex;
        flex-direction: column;
        align-items: center;
        gap: 6px;
        min-width: 110px;
        color: #a9825c;
        font-size: 12px;
        font-weight: 700;
        letter-spacing: 1px;
        text-transform: uppercase;
    }

    .rd-nights-line {
        position: relative;
        width: 100%;
        height: 1px;
        background: #d9c4a5;
    }

    .rd-nights-line::before,
    .rd-nights-line::after {
        content: "";
        position: absolute;
        top: -3px;
        width: 7px;
        height: 7px;
        border-radius: 50%;
        background: #a9825c;
    }

    .rd-nights-line::before { left: 0; }
    .rd-nights-line::after  { right: 0; }

    /* Info grid */
    .rd-info {
        display: grid;
        grid-template-columns: repeat(2, minmax(0, 1fr));
        gap: 0;
        margin: 0;
    }

    .rd-info-row {
        padding: 15px 0;
        border-bottom: 1px solid #eee2d0;
    }

    .rd-info-row:nth-last-child(-n+2) { border-bottom: 0; }
    .rd-info-row:nth-child(odd) { padding-right: 20px; }
    .rd-info-row:nth-child(even) { padding-left: 20px; border-left: 1px solid #eee2d0; }

    .rd-info-row dt {
        margin: 0 0 5px;
        color: #8a7f6f;
        font-size: 11px;
        font-weight: 700;
        letter-spacing: 1.2px;
        text-transform: uppercase;
    }

    .rd-info-row dd {
        margin: 0;
        font-size: 16px;
        font-weight: 600;
        overflow-wrap: anywhere;
    }

    /* Summary sidebar */
    .rd-side {
        position: sticky;
        top: 96px;
    }

    .rd-total-label {
        display: block;
        margin-bottom: 6px;
        color: #8a7f6f;
        font-size: 11px;
        font-weight: 700;
        letter-spacing: 1.4px;
        text-transform: uppercase;
    }

    .rd-total {
        margin-bottom: 18px;
        font-family: 'Playfair Display', serif;
        font-size: 34px;
        font-weight: 700;
        line-height: 1;
    }

    .rd-lines {
        margin: 0 0 18px;
        padding: 16px 0;
        border-top: 1px dashed #e5dccb;
        border-bottom: 1px dashed #e5dccb;
    }

    .rd-line {
        display: flex;
        justify-content: space-between;
        gap: 12px;
        padding: 5px 0;
        color: #5c5448;
        font-size: 14px;
    }

    .rd-line strong { color: #2b2621; }
    .rd-line.due strong { color: #b3261e; }

    .rd-note {
        margin: 0 0 14px;
        padding: 12px 14px;
        border-radius: 10px;
        font-size: 13px;
        line-height: 1.6;
    }

    .rd-note.success { background: #eef7ee; border: 1px solid #b9dcb9; color: #2e6b34; }
    .rd-note.warn    { background: #fdf6e7; border: 1px solid #ecd9a8; color: #7a5d1c; }
    .rd-note.danger  { background: #fdecea; border: 1px solid #f3b9b4; color: #b3261e; }

    .rd-btn {
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
        width: 100%;
        min-height: 48px;
        padding: 12px 18px;
        border: 1px solid transparent;
        border-radius: 10px;
        font-family: 'Jost', sans-serif;
        font-size: 13px;
        font-weight: 700;
        letter-spacing: 1px;
        text-transform: uppercase;
        text-decoration: none;
        cursor: pointer;
        transition: .2s ease;
    }

    .rd-btn + .rd-btn,
    .rd-btn + form,
    form + .rd-btn { margin-top: 10px; }

    .rd-btn-pay {
        background: #a9825c;
        color: #fff;
    }

    .rd-btn-pay:hover {
        background: #8a6844;
        color: #fff;
        text-decoration: none;
        transform: translateY(-1px);
    }

    .rd-btn-ghost {
        background: transparent;
        border-color: #e0b9b3;
        color: #b3261e;
    }

    .rd-btn-ghost:hover {
        background: #fdecea;
        border-color: #b3261e;
    }

    /* Responsive */
    @media (max-width: 960px) {
        .rd-layout { grid-template-columns: 1fr; }
        .rd-side { position: static; }
    }

    @media (max-width: 600px) {
        .rd-page { padding: 28px 0 60px; }
        .rd-shell { width: calc(100% - 24px); }
        .rd-card { padding: 20px 18px; }

        .rd-stay { grid-template-columns: 1fr; gap: 14px; }
        .rd-date.end { text-align: left; }
        .rd-nights { flex-direction: row; justify-content: flex-start; }
        .rd-nights-line { display: none; }
        .rd-date-big { font-size: 22px; }

        .rd-info { grid-template-columns: 1fr; }
        .rd-info-row,
        .rd-info-row:nth-child(odd),
        .rd-info-row:nth-child(even) { padding: 13px 0; border-left: 0; }
        .rd-info-row:nth-last-child(-n+2) { border-bottom: 1px solid #eee2d0; }
        .rd-info-row:last-child { border-bottom: 0; }
    }
</style>
@endpush

@section('content')
    @php
        $checkIn  = $reservation->check_in;
        $checkOut = $reservation->check_out;
        $nights   = ($checkIn && $checkOut) ? $checkIn->diffInDays($checkOut) : null;

        $invoice  = $reservation->invoice;

        $bookingBadge = [
            'Pending'     => 'b-pending',
            'Confirmed'   => 'b-confirmed',
            'Checked In'  => 'b-active',
            'Checked Out' => 'b-default',
            'Cancelled'   => 'b-cancelled',
            'Rejected'    => 'b-cancelled',
        ][$reservation->booking_status] ?? 'b-default';

        $paymentBadge = [
            'Paid'    => 'b-confirmed',
            'Partial' => 'b-active',
            'Pending' => 'b-pending',
        ][$reservation->payment_status] ?? 'b-default';

        $isInactive = in_array($reservation->booking_status, ['Cancelled', 'Rejected'], true);

        $payable   = $invoice ? ((float) $invoice->total_amount - (float) $invoice->discount) : (float) $reservation->total_amount;
        $paid      = $invoice ? (float) $invoice->paid_amount : 0;
        $remaining = max(0, round($payable - $paid, 2));

        $canCancel = in_array($reservation->booking_status, ['Pending', 'Confirmed'], true)
            && $reservation->payment_status === 'Pending'
            && (!$invoice || $invoice->payment_status === 'Pending');
    @endphp

    <div class="rd-page">
        <div class="rd-shell">

            <a href="{{ route('frontend.reservation.index') }}" class="rd-back">
                <i class="fas fa-arrow-left"></i> Back to My Reservations
            </a>

            {{-- Header --}}
            <header class="rd-header">
                <div>
                    <span class="rd-kicker">Hotel Luxura Palace · Your Stay</span>
                    <h1>Reservation {{ $reservation->booking_no }}</h1>
                    <p>
                        @if($reservation->created_at)
                            Booked on {{ $reservation->created_at->format('d M Y, h:i A') }}
                        @else
                            Stay and payment information
                        @endif
                    </p>
                </div>

                <div class="rd-badges">
                    <span class="rd-badge {{ $bookingBadge }}">{{ $reservation->booking_status }}</span>
                    <span class="rd-badge {{ $paymentBadge }}">Payment: {{ $reservation->payment_status ?? 'Pending' }}</span>
                </div>
            </header>

            <div class="rd-layout">

                {{-- LEFT --}}
                <div>

                    <section class="rd-card">
                        <h2 class="rd-card-title"><i class="fas fa-calendar-alt"></i> Your Stay</h2>

                        <div class="rd-stay">
                            <div class="rd-date">
                                <span class="rd-date-label">Check-in</span>
                                <div class="rd-date-big">{{ optional($checkIn)->format('d M Y') ?? '—' }}</div>
                                <span class="rd-date-sub">{{ optional($checkIn)->format('l') }}</span>
                            </div>

                            <div class="rd-nights">
                                <span>{{ $nights ?? '—' }} {{ $nights === 1 ? 'night' : 'nights' }}</span>
                                <div class="rd-nights-line"></div>
                            </div>

                            <div class="rd-date end">
                                <span class="rd-date-label">Check-out</span>
                                <div class="rd-date-big">{{ optional($checkOut)->format('d M Y') ?? '—' }}</div>
                                <span class="rd-date-sub">{{ optional($checkOut)->format('l') }}</span>
                            </div>
                        </div>
                    </section>

                    <section class="rd-card">
                        <h2 class="rd-card-title"><i class="fas fa-bed"></i> Room & Guests</h2>

                        <dl class="rd-info">
                            <div class="rd-info-row">
                                <dt>Room Type</dt>
                                <dd>{{ $reservation->room->roomType->name ?? '—' }}</dd>
                            </div>
                            <div class="rd-info-row">
                                <dt>Room Number</dt>
                                <dd>{{ $reservation->room->room_number ?? '—' }}</dd>
                            </div>
                            <div class="rd-info-row">
                                <dt>Floor</dt>
                                <dd>{{ $reservation->room->floor ?? '—' }}</dd>
                            </div>
                            <div class="rd-info-row">
                                <dt>Guests</dt>
                                <dd>
                                    {{ (int) $reservation->adults }} {{ (int) $reservation->adults === 1 ? 'Adult' : 'Adults' }}
                                    @if((int) $reservation->children > 0)
                                        , {{ (int) $reservation->children }} {{ (int) $reservation->children === 1 ? 'Child' : 'Children' }}
                                    @endif
                                </dd>
                            </div>
                        </dl>
                    </section>

                </div>

                {{-- RIGHT --}}
                <aside class="rd-side">
                    <section class="rd-card">
                        <h2 class="rd-card-title"><i class="fas fa-receipt"></i> Payment Summary</h2>

                        <span class="rd-total-label">Total Amount</span>
                        <div class="rd-total">₹{{ number_format($payable, 2) }}</div>

                        <div class="rd-lines">
                            @if($nights)
                                <div class="rd-line">
                                    <span>Stay length</span>
                                    <strong>{{ $nights }} {{ $nights === 1 ? 'night' : 'nights' }}</strong>
                                </div>
                            @endif
                            <div class="rd-line">
                                <span>Paid</span>
                                <strong>₹{{ number_format($paid, 2) }}</strong>
                            </div>
                            <div class="rd-line {{ $remaining > 0 ? 'due' : '' }}">
                                <span>Balance due</span>
                                <strong>₹{{ number_format($remaining, 2) }}</strong>
                            </div>
                        </div>

                        {{-- Payment state --}}
                        @if($isInactive)
                            <p class="rd-note danger">This reservation is {{ strtolower($reservation->booking_status) }}. No payment is required.</p>
                        @elseif($invoice && $invoice->payment_status === 'Paid')
                            <p class="rd-note success"><i class="fas fa-check-circle"></i> Payment completed successfully.</p>
                        @elseif($invoice)
                            <a href="{{ route('frontend.payment.create', $invoice->id) }}" class="rd-btn rd-btn-pay">
                                <i class="fas fa-lock"></i> Pay ₹{{ number_format($remaining, 2) }}
                            </a>
                        @else
                            <p class="rd-note warn"><i class="fas fa-info-circle"></i> Your invoice will be available after check-out.</p>
                        @endif

                        {{-- Cancel --}}
                        @if($canCancel)
                            <form action="{{ route('bookings.cancel', $reservation->id) }}" method="POST"
                                  onsubmit="return confirm('Are you sure you want to cancel this booking?');">
                                @csrf
                                <button type="submit" class="rd-btn rd-btn-ghost">
                                    <i class="fas fa-times-circle"></i> Cancel Booking
                                </button>
                            </form>
                        @endif
                    </section>
                </aside>

            </div>
        </div>
    </div>
@endsection