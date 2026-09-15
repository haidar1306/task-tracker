@extends('frontend.layouts.app')

@section('title', 'Rooms')
@push('after-styles')
<style>
    /* ===========================
   ROOM SECTION
=========================== */

    .room-section {
        position: relative;
        background:
            linear-gradient(180deg, rgba(43,38,33,.55) 0%, rgba(43,38,33,.75) 100%),
            url('https://images.unsplash.com/photo-1566073771259-6a8506099945?w=1600') center/cover no-repeat;
        padding: 90px 0;
        margin-bottom: 48px;
    }

    .room-subtitle {
        display: inline-block;
        padding: 10px 28px;
        background: transparent;
        border: 1px solid #d9c4a5;
        color: #f0e6d4;
        border-radius: 50px;
        text-transform: uppercase;
        letter-spacing: 3px;
        font-size: 13px;
        font-weight: 700;
        margin-bottom: 30px;
    }

    .room-title {
        font-size: 52px;
        font-weight: 700;
        color: #fffdfa;
        line-height: 1.2;
        margin-bottom: 20px;
        letter-spacing: -0.02em;
        font-family: 'Playfair Display', serif;
    }

    .room-divider {
        width: 90px;
        height: 2px;
        background: #d9c4a5;
        margin: 0 auto 30px;
        border-radius: 20px;
    }

    .room-desc {
        max-width: 700px;
        margin: auto;
        font-size: 17px;
        line-height: 1.9;
        color: #e8dcc8;
        font-family: 'Jost', sans-serif;
    }

    @media (max-width: 768px) {
        .room-title {
            font-size: 36px;
        }

        .room-section {
            padding: 60px 0;
            margin-bottom: 32px;
        }
    }

    /* ===========================
       ROOM CARDS (grid, reference style)
    =========================== */

    .room-cards {
        row-gap: 30px;
    }

    .room-card {
        overflow: hidden;
        border: 1px solid #e5dccb !important;
        border-radius: 14px;
        box-shadow: 0 10px 26px rgba(43, 38, 33, .06) !important;
        background: #fffdfa;
        transition: transform .3s ease, box-shadow .3s ease;
    }

    .room-card:hover {
        transform: translateY(-6px);
        box-shadow: 0 18px 36px rgba(43, 38, 33, .12) !important;
    }

    .room-card-header {
        padding: 14px 20px;
        border-bottom: 1px solid #eee2d0;
        background: #f7f2ea;
        font-family: 'Playfair Display', serif;
        font-weight: 700;
        font-size: 17px;
        color: #2b2621;
    }

    .room-card .card-img-top {
        display: block;
        height: 220px;
        width: 100%;
        object-fit: cover;
    }

    .room-card .card-body {
        padding: 22px 20px;
    }

    .room-card-roomno {
        color: #8a7f6f;
        font-size: 13px;
        margin-bottom: 10px;
    }

    .room-card-desc {
        color: #8a7f6f;
        font-size: 14px;
        line-height: 1.7;
        margin-bottom: 18px;
    }

    .room-card-meta {
        display: flex;
        gap: 18px;
        margin-bottom: 16px;
    }

    .room-card-meta span {
        color: #8a7f6f;
        font-size: 13px;
    }

    .room-card-meta i {
        color: #a9825c;
        margin-right: 5px;
    }

    .room-amenity-badge {
        display: inline-block;
        background: #f0e6d4;
        color: #6b5a3e;
        padding: 4px 11px;
        border-radius: 30px;
        font-size: 11px;
        margin: 0 6px 6px 0;
    }

    .room-status-badge {
        display: inline-block;
        padding: 4px 13px;
        border-radius: 30px;
        font-size: 11px;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.04em;
        margin-bottom: 14px;
    }

    .room-status-badge.available {
        background: #eaf2e6;
        color: #4f7a4a;
    }

    .room-status-badge.unavailable {
        background: #f7e6df;
        color: #b3532b;
    }

    .room-card-footer {
        display: flex;
        align-items: center;
        justify-content: space-between;
        border-top: 1px solid #eee2d0;
        padding-top: 16px;
        margin-top: 6px;
    }

    .room-book-btn {
        display: inline-block;
        padding: 9px 22px;
        border: 1px solid #a9825c;
        color: #a9825c;
        border-radius: 30px;
        text-decoration: none;
        font-weight: 600;
        font-size: 13px;
        letter-spacing: 0.02em;
        transition: 0.3s;
    }

    .room-book-btn:hover {
        background: #a9825c;
        color: #fff;
    }

    .room-card-price {
        font-family: 'Playfair Display', serif;
        color: #2b2621;
        font-size: 17px;
        font-weight: 700;
    }

    .room-card-price small {
        font-family: 'Jost', sans-serif;
        color: #8a7f6f;
        font-size: 12px;
        font-weight: 400;
    }
</style>
@endpush

@section('content')

    <section class="py-5">

        <div class="container">

            <div class="room-section">

                <div class="container">

                    <div class="text-center position-relative">

                        <span class="room-subtitle">
                            Luxury Collection
                        </span>

                        <h2 class="room-title">
                            Discover Exceptional <br>
                            Luxury Rooms
                        </h2>

                        <div class="room-divider"></div>

                        <p class="room-desc">
                            Every room is thoughtfully crafted with elegant interiors,
                            premium comfort and modern hospitality to deliver a memorable
                            stay for every guest.
                        </p>

                    </div>

                </div>

            </div>

            <div class="row room-cards">

                @foreach($rooms as $room)

                    <div class="col-lg-4 col-md-6 mb-4">

                        <article class="card room-card h-100">

                            <div class="room-card-header">
                                {{ $room->roomType->name ?? 'Room' }}
                            </div>

                            @if($room->image)
                                <img src="{{ $room->image }}" class="card-img-top">
                            @elseif($room->roomType->image)
                                <img src="{{ $room->roomType->image }}" class="card-img-top">
                            @else
                                <img src="{{ asset('images/default-room.jpg') }}" class="card-img-top">
                            @endif

                            <div class="card-body">

                                <p class="room-card-roomno">Room No: {{ $room->room_number }}</p>

                                @if($room->status)
                                    <span class="room-status-badge available">Available</span>
                                @else
                                    <span class="room-status-badge unavailable">Booked</span>
                                @endif

                                <div class="room-card-meta">
                                    <span><i class="fas fa-building"></i> Floor {{ $room->floor ?? 'N/A' }}</span>
                                    <span><i class="fas fa-users"></i> {{ $room->roomType->capacity ?? '-' }} Guests</span>
                                </div>

                                <p class="room-card-desc">
                                    {{ $room->roomType->description ?? 'A thoughtfully designed room offering comfort, elegance and a memorable stay experience.' }}
                                </p>

                                <div class="mb-2">
                                    @foreach($room->amenities->take(4) as $amenity)
                                        <span class="room-amenity-badge">
                                            <i class="fas fa-check"></i> {{ $amenity->name }}
                                        </span>
                                    @endforeach
                                </div>

                                <div class="room-card-footer">

                                    <a href="{{ route('frontend.room.show', $room->id) }}" class="room-book-btn">
                                        Book
                                    </a>

                                    <span class="room-card-price">
                                        ₹{{ number_format($room->roomType->price, 0) }}
                                        <small>/ night</small>
                                    </span>

                                </div>

                            </div>

                        </article>

                    </div>

                @endforeach

            </div>

        </div>

    </section>

@endsection