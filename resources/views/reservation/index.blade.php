@extends('frontend.layouts.app')

@section('title', 'My Reservations')

@push('after-styles')
<style>
    .res-hero {
        min-height: 38vh;
        display: flex;
        align-items: center;
        justify-content: center;
        text-align: center;
        padding: 40px 16px;
        background:
            linear-gradient(180deg, rgba(43,38,33,.55), rgba(43,38,33,.80)),
            url('https://images.unsplash.com/photo-1611892440504-42a792e24d32?w=1600') center/cover no-repeat;
    }

    .res-hero .kicker {
        display: inline-block;
        padding: 8px 22px;
        margin-bottom: 16px;
        border: 1px solid #d9c4a5;
        border-radius: 30px;
        color: #f0e6d4;
        font-size: 12px;
        font-weight: 600;
        letter-spacing: 3px;
        text-transform: uppercase;
    }

    .res-hero h1 {
        margin: 0 0 12px;
        color: #fffdfa;
        font-family: 'Playfair Display', serif;
        font-size: clamp(2rem, 4.5vw, 3.2rem);
        font-weight: 700;
    }

    .res-hero p {
        max-width: 480px;
        margin: 0 auto;
        color: #e8dcc8;
        font-size: 16px;
    }

    .res-page {
        padding: 0 0 90px;
        background: #f7f2ea;
    }

    .res-toolbar {
        display: flex;
        align-items: center;
        justify-content: space-between;
        flex-wrap: wrap;
        gap: 14px;
        padding: 38px 0 22px;
    }

    .res-toolbar h2 {
        margin: 0;
        color: #2b2621;
        font-family: 'Playfair Display', serif;
        font-size: 1.7rem;
        font-weight: 700;
    }

    .res-toolbar small {
        display: block;
        margin-top: 4px;
        color: #8a7f6f;
        font-family: 'Jost', sans-serif;
        font-size: 13px;
    }

    .res-btn {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        padding: 11px 22px;
        border-radius: 8px;
        background: #a9825c;
        color: #fff;
        font-family: 'Jost', sans-serif;
        font-size: 13px;
        font-weight: 600;
        text-decoration: none;
        white-space: nowrap;
        transition: background .2s ease, transform .2s ease;
    }

    .res-btn:hover {
        background: #8a6844;
        color: #fff;
        text-decoration: none;
        transform: translateY(-1px);
    }

    .res-alert {
        margin-bottom: 18px;
        padding: 14px 18px;
        border-radius: 8px;
        font-family: 'Jost', sans-serif;
        font-size: 14px;
    }

    .res-alert.success { background: #eef7ee; border: 1px solid #b9dcb9; color: #2e6b34; }
    .res-alert.danger  { background: #fdecea; border: 1px solid #f3b9b4; color: #b3261e; }

    /* Card + table */
    .res-card {
        background: #fffdfa;
        border: 1px solid #e5dccb;
        border-radius: 16px;
        box-shadow: 0 14px 34px rgba(43,38,33,.06);
        overflow: hidden;
    }

    .res-table {
        width: 100%;
        border-collapse: collapse;
        font-family: 'Jost', sans-serif;
    }

    .res-table thead th {
        padding: 16px 18px;
        background: #4a4034;
        color: #f0e6d4;
        font-size: 12px;
        font-weight: 700;
        letter-spacing: 1px;
        text-transform: uppercase;
        white-space: nowrap;
        text-align: left;
    }

    .res-table tbody td {
        padding: 17px 18px;
        border-bottom: 1px solid #eee2d0;
        color: #3a352e;
        font-size: 14px;
        vertical-align: middle;
    }

    .res-table tbody tr:last-child td { border-bottom: 0; }
    .res-table tbody tr:hover td { background: #faf6ee; }

    .res-booking-no { font-weight: 700; color: #2b2621; }
    .res-sub { display: block; color: #8a7f6f; font-size: 12px; }
    .res-amount { font-family: 'Playfair Display', serif; font-weight: 600; white-space: nowrap; }

    .res-badge {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        padding: 6px 12px;
        border-radius: 999px;
        font-size: 11px;
        font-weight: 700;
        letter-spacing: .5px;
        text-transform: uppercase;
        white-space: nowrap;
    }

    .res-badge::before {
        content: "";
        width: 6px;
        height: 6px;
        border-radius: 50%;
        background: currentColor;
    }

    .badge-pending   { background: rgba(169,130,92,.14); color: #8a6844; }
    .badge-confirmed { background: rgba(79,122,74,.12);  color: #4f7a4a; }
    .badge-active    { background: rgba(52,110,170,.12); color: #2f6aa8; }
    .badge-cancelled { background: rgba(179,83,43,.12);  color: #b3532b; }
    .badge-default   { background: rgba(138,127,111,.14); color: #8a7f6f; }

    .res-empty {
        padding: 60px 24px;
        text-align: center;
        font-family: 'Jost', sans-serif;
    }

    .res-empty i { margin-bottom: 14px; color: #d9c4a5; font-size: 40px; }
    .res-empty h3 { margin: 0 0 8px; color: #2b2621; font-family: 'Playfair Display', serif; font-size: 1.4rem; }
    .res-empty p { margin: 0 0 20px; color: #8a7f6f; }

    .res-pagination { padding: 6px 20px 22px; }

    /* Tablet: horizontal scroll na ho, kam important columns chhupao */
    @media (max-width: 1100px) {
        .res-hide-md { display: none; }
    }

    /* Mobile: table -> cards */
    @media (max-width: 768px) {
        .res-table, .res-table tbody, .res-table tr, .res-table td { display: block; width: 100%; }
        .res-table thead { display: none; }

        .res-table tbody tr {
            padding: 16px 18px;
            border-bottom: 1px solid #eee2d0;
        }

        .res-table tbody tr:last-child { border-bottom: 0; }

        .res-table tbody td {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 16px;
            padding: 8px 0;
            border: 0;
            text-align: right;
        }

        .res-table tbody tr:hover td { background: transparent; }

        .res-table tbody td::before {
            content: attr(data-label);
            flex-shrink: 0;
            color: #8a7f6f;
            font-size: 11px;
            font-weight: 700;
            letter-spacing: 1px;
            text-transform: uppercase;
            text-align: left;
        }

        .res-hide-md { display: flex !important; }

        .res-table td.res-cell-action { padding-top: 14px; }
        .res-table td.res-cell-action::before { display: none; }
        .res-table td.res-cell-action .res-btn { width: 100%; justify-content: center; }

        .res-toolbar .res-btn { width: 100%; justify-content: center; }
    }
</style>
@endpush

@section('content')
    @php
        $statusClass = [
            'Pending'     => 'badge-pending',
            'Confirmed'   => 'badge-confirmed',
            'Checked In'  => 'badge-active',
            'Checked Out' => 'badge-default',
            'Cancelled'   => 'badge-cancelled',
            'Rejected'    => 'badge-cancelled',
        ];

        $paymentClass = [
            'Paid'    => 'badge-confirmed',
            'Partial' => 'badge-active',
            'Pending' => 'badge-pending',
        ];
    @endphp

    <section class="res-hero page-hero">
        <div class="container">
            <span class="kicker">Your Stays</span>
            <h1>My Reservations</h1>
            <p>Track your bookings, payment progress, and stay details in one place.</p>
        </div>
    </section>

    <div class="res-page">
        <div class="container">

            <div class="res-toolbar">
                <div>
                    <h2>Room Reservations</h2>
                    <small>
                        {{ $reservations->total() }}
                        {{ $reservations->total() === 1 ? 'reservation' : 'reservations' }} in total
                    </small>
                </div>

                <a href="{{ route('frontend.room.index') }}" class="res-btn">
                    <i class="fas fa-plus"></i> Book a Room
                </a>
            </div>

            @if (session('success') || session('flash_success'))
                <div class="res-alert success" role="alert">
                    {{ session('success') ?? session('flash_success') }}
                </div>
            @endif

            @if (session('error') || session('flash_danger'))
                <div class="res-alert danger" role="alert">
                    {{ session('error') ?? session('flash_danger') }}
                </div>
            @endif

            <div class="res-card">

                @if ($reservations->isEmpty())
                    <div class="res-empty">
                        <i class="fas fa-calendar-times"></i>
                        <h3>No reservations yet</h3>
                        <p>When you book a room, it will appear here.</p>
                        <a href="{{ route('frontend.room.index') }}" class="res-btn">Browse Rooms</a>
                    </div>
                @else
                    <table class="res-table">
                        <thead>
                            <tr>
                                <th>Booking</th>
                                <th>Room</th>
                                <th>Check In</th>
                                <th>Check Out</th>
                                <th class="res-hide-md">Amount</th>
                                <th>Status</th>
                                <th class="res-hide-md">Payment</th>
                                <th></th>
                            </tr>
                        </thead>

                        <tbody>
                            @foreach ($reservations as $reservation)
                                @php
                                    $bookingStatus = $reservation->booking_status;
                                    $paymentStatus = $reservation->payment_status ?? 'Pending';
                                @endphp

                                <tr>
                                    <td data-label="Booking" class="res-booking-no">
                                        {{ $reservation->booking_no }}
                                    </td>

                                    <td data-label="Room">
                                        <div>
                                            Room {{ $reservation->room->room_number ?? 'N/A' }}
                                            <span class="res-sub">
                                                {{ $reservation->room->roomType->name ?? 'N/A' }}
                                            </span>
                                        </div>
                                    </td>

                                    <td data-label="Check In">
                                        {{ optional($reservation->check_in)->format('d M Y') }}
                                    </td>

                                    <td data-label="Check Out">
                                        {{ optional($reservation->check_out)->format('d M Y') }}
                                    </td>

                                    <td data-label="Amount" class="res-hide-md res-amount">
                                        ₹{{ number_format((float) $reservation->total_amount, 2) }}
                                    </td>

                                    <td data-label="Status">
                                        <span class="res-badge {{ $statusClass[$bookingStatus] ?? 'badge-default' }}">
                                            {{ $bookingStatus }}
                                        </span>
                                    </td>

                                    <td data-label="Payment" class="res-hide-md">
                                        <span class="res-badge {{ $paymentClass[$paymentStatus] ?? 'badge-default' }}">
                                            {{ $paymentStatus }}
                                        </span>
                                    </td>

                                    <td data-label="" class="res-cell-action">
                                        <a href="{{ route('frontend.reservation.show', $reservation->id) }}"
                                            class="res-btn">
                                            View Details
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>

                    @if ($reservations->hasPages())
                        <div class="res-pagination">
                            {{ $reservations
                                ->appends(request()->except('local_page'))
                                ->onEachSide(1)
                                ->links('vendor.pagination.admin', ['label' => 'reservations']) }}
                        </div>
                    @endif
                @endif

            </div>
        </div>
    </div>
@endsection