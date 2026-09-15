@extends('frontend.layouts.app')

@section('title', 'My Reservations')

@section('content')

<style>
    .reservation-hero {
        position: relative;
        width: 100%;
        min-height: 42vh;
        display: flex;
        align-items: center;
        justify-content: center;
        background:
            linear-gradient(180deg, rgba(43,38,33,.55) 0%, rgba(43,38,33,.78) 100%),
            url('https://images.unsplash.com/photo-1611892440504-42a792e24d32?w=1600') center/cover no-repeat;
        text-align: center;
        margin-bottom: 48px;
    }

    .reservation-hero span.kicker {
        display: inline-block;
        padding: 8px 24px;
        border: 1px solid #d9c4a5;
        color: #f0e6d4;
        border-radius: 30px;
        letter-spacing: 3px;
        font-size: 12px;
        font-weight: 600;
        text-transform: uppercase;
        margin-bottom: 18px;
    }

    .reservation-hero h2 {
        font-family: 'Playfair Display', serif;
        font-size: clamp(2rem, 4vw, 3rem);
        font-weight: 700;
        color: #fffdfa;
        margin: 0 0 12px;
    }

    .reservation-hero p {
        color: #e8dcc8;
        font-size: 16px;
        max-width: 480px;
        margin: 0 auto;
    }

    .reservation-page {
        padding: 0 0 90px;
        background: #f7f2ea;
    }

    .reservation-summary {
        display: grid;
        grid-template-columns: repeat(4, minmax(0, 1fr));
        gap: 18px;
        margin-bottom: 28px;
    }

    .summary-box {
        background: #fffdfa;
        border: 1px solid #e5dccb;
        border-radius: 14px;
        padding: 22px 20px;
    }

    .summary-label {
        display: block;
        font-size: 0.78rem;
        letter-spacing: 0.12em;
        text-transform: uppercase;
        color: #8a7f6f;
        margin-bottom: 10px;
    }

    .summary-value {
        font-family: 'Playfair Display', serif;
        font-size: 1.8rem;
        font-weight: 700;
        color: #2b2621;
    }

    .reservation-card {
        background: #fffdfa;
        border: 1px solid #e5dccb;
        border-radius: 16px;
        overflow: hidden;
    }

    .reservation-card .card-body {
        padding: 0;
    }

    .reservation-table-wrap {
        overflow-x: auto;
    }

    .reservation-table {
        width: 100%;
        border-collapse: collapse;
        min-width: 900px;
    }

    .reservation-table thead th {
        background: #4a4034;
        color: #f0e6d4;
        font-weight: 700;
        font-size: 0.8rem;
        letter-spacing: 0.08em;
        text-transform: uppercase;
        padding: 18px 18px;
        border: none;
    }

    .reservation-table tbody td {
        padding: 20px 18px;
        border-bottom: 1px solid #eee2d0;
        color: #3a352e;
        vertical-align: middle;
        background: #fffdfa;
    }

    .reservation-table tbody tr:hover td {
        background: #f7f2ea;
    }

    .booking-no {
        font-weight: 700;
        color: #2b2621;
    }

    .reservation-status {
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

    .status-pending {
        background: rgba(169, 130, 92, 0.14);
        color: #8a6844;
    }

    .status-confirmed {
        background: rgba(79, 122, 74, 0.12);
        color: #4f7a4a;
    }

    .status-cancelled {
        background: rgba(179, 83, 43, 0.12);
        color: #b3532b;
    }

    .status-default {
        background: rgba(138, 127, 111, 0.14);
        color: #8a7f6f;
    }

    .reservation-action {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        padding: 10px 16px;
        border-radius: 8px;
        background: #a9825c;
        color: #fff;
        font-weight: 600;
        font-size: 13px;
        text-decoration: none;
        transition: all 0.2s ease;
    }

    .reservation-action:hover {
        background: #8a6844;
        color: #fff;
        text-decoration: none;
    }

    .empty-state {
        padding: 46px 24px;
        text-align: center;
        color: #8a7f6f;
    }

    .empty-state h5 {
        margin: 0;
        font-family: 'Playfair Display', serif;
        font-size: 1.25rem;
        color: #2b2621;
    }

    @media (max-width: 768px) {
        .reservation-summary {
            grid-template-columns: repeat(2, minmax(0, 1fr));
        }
    }

    @media (max-width: 520px) {
        .reservation-summary {
            grid-template-columns: 1fr;
        }
    }
</style>

<section class="reservation-hero page-hero">
    <div class="container">
        <span class="kicker">Your Stays</span>
        <h2>My Reservations</h2>
        <p>Track your bookings, payment progress, and stay details in one place.</p>
    </div>
</section>

<div class="reservation-page">
    <div class="container">

        <div class="reservation-summary">
            <div class="summary-box">
                <span class="summary-label">Total</span>
                <span class="summary-value">{{ $reservations->count() }}</span>
            </div>
            <div class="summary-box">
                <span class="summary-label">Confirmed</span>
                <span class="summary-value">{{ $reservations->where('booking_status', 'Confirmed')->count() }}</span>
            </div>
            <div class="summary-box">
                <span class="summary-label">Pending</span>
                <span class="summary-value">{{ $reservations->where('booking_status', 'Pending')->count() }}</span>
            </div>
            <div class="summary-box">
                <span class="summary-label">Cancelled</span>
                <span class="summary-value">{{ $reservations->where('booking_status', 'Cancelled')->count() }}</span>
            </div>
        </div>

        <div class="reservation-card">
            <div class="card-body">
                <div class="reservation-table-wrap">
                    <table class="reservation-table">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Booking No</th>
                                <th>Room</th>
                                <th>Room Type</th>
                                <th>Check In</th>
                                <th>Check Out</th>
                                <th>Amount</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($reservations as $reservation)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td class="booking-no">{{ $reservation->booking_no }}</td>
                                    <td>{{ $reservation->room->room_number ?? 'N/A' }}</td>
                                    <td>{{ $reservation->room->roomType->name ?? 'N/A' }}</td>
                                    <td>{{ \Carbon\Carbon::parse($reservation->check_in)->format('d M Y') }}</td>
                                    <td>{{ \Carbon\Carbon::parse($reservation->check_out)->format('d M Y') }}</td>
                                    <td>₹{{ number_format($reservation->total_amount, 2) }}</td>
                                    <td>
                                        @if($reservation->booking_status == 'Pending')
                                            <span class="reservation-status status-pending">Pending</span>
                                        @elseif($reservation->booking_status == 'Confirmed')
                                            <span class="reservation-status status-confirmed">Confirmed</span>
                                        @elseif($reservation->booking_status == 'Cancelled')
                                            <span class="reservation-status status-cancelled">Cancelled</span>
                                        @else
                                            <span class="reservation-status status-default">{{ $reservation->booking_status }}</span>
                                        @endif
                                    </td>
                                    <td>
                                        <a href="{{ route('frontend.reservation.show', $reservation->id) }}" class="reservation-action">
                                            View Details
                                        </a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="9">
                                        <div class="empty-state">
                                            <h5>No reservations found</h5>
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                @if($reservations->hasPages())
                    <div class="d-flex justify-content-center mt-4 px-3 pb-4">
                        {{ $reservations->links() }}
                    </div>
                @endif
            </div>
        </div>

    </div>
</div>

@endsection