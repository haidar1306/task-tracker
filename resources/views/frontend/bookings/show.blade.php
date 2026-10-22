@extends('frontend.layouts.apps')

@section('title', 'Booking ' . $booking->booking_no)

@push('after-styles')
    <style>
        .bk-page {
            background: #f4f0e8;
            min-height: 100vh;
            padding: 130px 24px 80px;
            font-family: 'Jost', sans-serif;
            color: #25211d;
        }

        .bk-card {
            max-width: 760px;
            margin: 0 auto;
            background: #fffdf9;
            border: 1px solid #e8e0d3;
            box-shadow: 0 20px 55px rgba(37, 33, 29, .08);
            padding: 42px;
        }

        .bk-top {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            gap: 16px;
            flex-wrap: wrap;
            margin-bottom: 26px;
        }

        .bk-kicker {
            font-size: 10px;
            letter-spacing: 2.5px;
            text-transform: uppercase;
            color: #9f7925;
            font-weight: 600;
        }

        .bk-title {
            font-family: 'Playfair Display', serif;
            font-size: 34px;
            font-weight: 500;
            margin: 8px 0 0;
        }

        .bk-badge {
            display: inline-block;
            padding: 8px 14px;
            border-radius: 30px;
            font-size: 11px;
            font-weight: 600;
            letter-spacing: .8px;
            text-transform: uppercase;
            background: #eee9df;
            color: #6d6253;
            border: 1px solid #ddd3c2;
        }

        .bk-badge.ok {
            background: #e7f5ec;
            color: #1d7a3b;
            border-color: #bfe3cb;
        }

        .bk-badge.wait {
            background: #fdf3e2;
            color: #8a5a0b;
            border-color: #f1d9ab;
        }

        .bk-badge.bad {
            background: #fbeaea;
            color: #a12b2b;
            border-color: #f0c4c4;
        }

        .bk-row {
            display: flex;
            justify-content: space-between;
            gap: 20px;
            padding: 13px 0;
            border-bottom: 1px solid #f0ebe3;
            font-size: 14px;
        }

        .bk-row span:first-child {
            color: #918678;
        }

        .bk-row span:last-child {
            font-weight: 500;
            text-align: right;
        }

        .bk-total {
            font-family: 'Playfair Display', serif;
            font-size: 30px;
        }

        .bk-actions {
            display: flex;
            gap: 12px;
            flex-wrap: wrap;
            margin-top: 30px;
        }

        .bk-btn {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 14px 22px;
            font-size: 11px;
            font-weight: 600;
            letter-spacing: 1px;
            text-transform: uppercase;
            text-decoration: none;
            border: 1px solid #25211d;
            background: #25211d;
            color: #fff;
            cursor: pointer;
        }

        .bk-btn.ghost {
            background: transparent;
            color: #25211d;
        }

        .bk-btn.danger {
            background: transparent;
            color: #a12b2b;
            border-color: #a12b2b;
        }

        .bk-note {
            margin-top: 22px;
            font-size: 12px;
            color: #918678;
            line-height: 1.7;
        }
    </style>
@endpush

@section('content')
    @php
        $badge = in_array($booking->booking_status, ['Confirmed', 'Checked In', 'Checked Out'], true) ? 'ok'
            : ($booking->booking_status === 'Pending' ? 'wait' : 'bad');
    @endphp

    <div class="bk-page">
        <div class="bk-card">

            <div class="bk-top">
                <div>
                    <div class="bk-kicker">Reservation</div>
                    <h1 class="bk-title">{{ $booking->booking_no }}</h1>
                </div>
                <span class="bk-badge {{ $badge }}">{{ $booking->booking_status }}</span>
            </div>

            <div class="bk-row"><span>Room</span><span>{{ optional(optional($booking->room)->roomType)->name }} ·
                    {{ optional($booking->room)->room_number }}</span></div>
            <div class="bk-row"><span>Check In</span><span>{{ $booking->check_in->format('d M Y') }}</span></div>
            <div class="bk-row"><span>Check Out</span><span>{{ $booking->check_out->format('d M Y') }}</span></div>
            <div class="bk-row"><span>Nights</span><span>{{ $booking->nights() }}</span></div>
            <div class="bk-row"><span>Guests</span><span>{{ $booking->adults }} adult(s), {{ $booking->children }}
                    child(ren)</span></div>
            <div class="bk-row"><span>Payment</span><span>{{ $booking->payment_status }}</span></div>
            <div class="bk-row"><span>Total</span><span
                    class="bk-total">₹{{ number_format($booking->total_amount, 2) }}</span></div>

            @if($booking->booking_status === 'Pending')
                <p class="bk-note">Your reservation is awaiting admin confirmation. If it is not confirmed within 24 hours it
                    will be released automatically.</p>
            @endif

            <div class="bk-actions">
                <a href="{{ route('bookings.index') }}" class="bk-btn ghost">My Bookings</a>
                <a href="{{ route('frontend.room.index') }}" class="bk-btn ghost">Browse Rooms</a>

                @if($booking->isCancellableByGuest())
                    <form action="{{ route('bookings.cancel', $booking) }}" method="POST"
                        onsubmit="return confirm('Cancel this booking?')">
                        @csrf
                        <button type="submit" class="bk-btn danger">Cancel Booking</button>
                    </form>
                @endif
            </div>

        </div>
    </div>
@endsection