@extends('frontend.layouts.apps')

@section('title', 'My Bookings')

@push('after-styles')
    <style>
        .mb-page {
            background: #f4f0e8;
            min-height: 100vh;
            padding: 130px 24px 80px;
            font-family: 'Jost', sans-serif;
            color: #25211d;
        }

        .mb-wrap {
            max-width: 960px;
            margin: 0 auto;
        }

        .mb-wrap h1 {
            font-family: 'Playfair Display', serif;
            font-size: 36px;
            font-weight: 500;
            margin: 0 0 24px;
        }

        .mb-item {
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 18px;
            flex-wrap: wrap;
            background: #fffdf9;
            border: 1px solid #e8e0d3;
            padding: 22px 26px;
            margin-bottom: 14px;
            text-decoration: none;
            color: inherit;
        }

        .mb-item:hover {
            box-shadow: 0 14px 34px rgba(37, 33, 29, .09);
            color: inherit;
        }

        .mb-no {
            font-size: 11px;
            letter-spacing: 1.5px;
            text-transform: uppercase;
            color: #9f7925;
            font-weight: 600;
        }

        .mb-room {
            font-family: 'Playfair Display', serif;
            font-size: 20px;
            margin: 4px 0;
        }

        .mb-dates {
            font-size: 13px;
            color: #918678;
        }

        .mb-right {
            text-align: right;
        }

        .mb-status {
            display: inline-block;
            padding: 6px 12px;
            border-radius: 30px;
            font-size: 10px;
            font-weight: 600;
            letter-spacing: .8px;
            text-transform: uppercase;
            background: #eee9df;
            color: #6d6253;
        }

        .mb-total {
            margin-top: 8px;
            font-family: 'Playfair Display', serif;
            font-size: 20px;
        }

        .mb-empty {
            background: #fffdf9;
            border: 1px solid #e8e0d3;
            padding: 50px;
            text-align: center;
            color: #918678;
        }
    </style>
@endpush

@section('content')
    <div class="mb-page">
        <div class="mb-wrap">
            <h1>My Bookings</h1>

            @forelse($bookings as $booking)
                <a href="{{ route('bookings.show', $booking) }}" class="mb-item">
                    <div>
                        <div class="mb-no">{{ $booking->booking_no }}</div>
                        <div class="mb-room">{{ optional(optional($booking->room)->roomType)->name }} ·
                            {{ optional($booking->room)->room_number }}</div>
                        <div class="mb-dates">{{ $booking->check_in->format('d M Y') }} →
                            {{ $booking->check_out->format('d M Y') }} · {{ $booking->nights() }} night(s)</div>
                    </div>
                    <div class="mb-right">
                        <span class="mb-status">{{ $booking->booking_status }}</span>
                        <div class="mb-total">₹{{ number_format($booking->total_amount, 2) }}</div>
                    </div>
                </a>
            @empty
                <div class="mb-empty">
                    You have no bookings yet.<br><br>
                    <a href="{{ route('frontend.room.index') }}">Browse rooms</a>
                </div>
            @endforelse

            <div class="mt-4">{{ $bookings->links() }}</div>
        </div>
    </div>
@endsection