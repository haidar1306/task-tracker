@extends('frontend.layouts.app')

@section('title', 'My Reservations')

@section('content')

<style>
    .reservation-page {
        padding: 70px 0 90px;
        background: linear-gradient(180deg, #f8f5f2 0%, #f3f6f8 100%);
    }

    .reservation-header {
        margin-bottom: 28px;
    }

    .reservation-header h2 {
        font-size: clamp(2rem, 4vw, 3rem);
        font-weight: 800;
        color: #23489f;
        margin: 0;
    }

    .reservation-subtitle {
        color: #607083;
        font-size: 1rem;
        margin-top: 8px;
    }

    .reservation-summary {
        display: grid;
        grid-template-columns: repeat(4, minmax(0, 1fr));
        gap: 18px;
        margin-bottom: 28px;
    }

    .summary-box {
        background: #fff;
        border: 1px solid rgba(19, 33, 52, 0.06);
        border-radius: 18px;
        padding: 22px 20px;
        box-shadow: 0 16px 36px rgba(16, 24, 40, 0.06);
    }

    .summary-label {
        display: block;
        font-size: 0.78rem;
        letter-spacing: 0.12em;
        text-transform: uppercase;
        color: #6c7a89;
        margin-bottom: 10px;
    }

    .summary-value {
        font-size: 1.8rem;
        font-weight: 800;
        color: #162534;
    }

    .reservation-card {
        background: #fff;
        border: 1px solid rgba(19, 33, 52, 0.06);
        border-radius: 22px;
        box-shadow: 0 22px 55px rgba(15, 23, 42, 0.07);
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
        background:     #080807;
        color: #fff;
        font-weight: 700;
        font-size: 0.8rem;
        letter-spacing: 0.08em;
        text-transform: uppercase;
        padding: 18px 18px;
        border: none;
    }

    .reservation-table tbody td {
        padding: 20px 18px;
        border-bottom: 1px solid rgba(15, 23, 42, 0.06);
        color: #243244;
        vertical-align: middle;
        background: #fff;
    }

    .reservation-table tbody tr:hover td {
        background: #fafbfc;
    }

    .booking-no {
        font-weight: 700;
        color: #1a2433;
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
        background: rgba(245, 158, 11, 0.12);
        color: #b45309;
    }

    .status-confirmed {
        background: rgba(16, 185, 129, 0.12);
        color: #047857;
    }

    .status-cancelled {
        background: rgba(239, 68, 68, 0.12);
        color: #b91c1c;
    }

    .status-default {
        background: rgba(148, 163, 184, 0.14);
        color: #475569;
    }

    .reservation-action {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        padding: 10px 16px;
        border-radius: 12px;
        background: #0d1241;
        color: #fff;
        font-weight: 700;
        text-decoration: none;
        transition: all 0.2s ease;
    }

    .reservation-action:hover {
        background: #c99445;
        color: #fff;
        text-decoration: none;
    }

    .empty-state {
        padding: 46px 24px;
        text-align: center;
        color: #46576c;
    }

    .empty-state h5 {
        margin: 0;
        font-size: 1.25rem;
        color: #1e293b;
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

<div class="reservation-page">
    <div class="container">
        <div class="reservation-header">
            <h2>My Reservations</h2>
            <div class="reservation-subtitle">Track your bookings, payment progress, and stay details in one place.</div>
        </div>

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