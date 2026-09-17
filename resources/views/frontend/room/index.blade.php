@extends('frontend.layouts.app')

@section('title', 'Rooms')

@push('after-styles')
    <style>
        /* ===========================
           HERO
        =========================== */

        .rooms-hero {
            background: #14100c;
            overflow: hidden;
        }

        .rooms-hero-inner {
            max-width: 1400px;
            margin: 0 auto;
            display: grid;
            grid-template-columns: 1fr 1.3fr;
            align-items: stretch;
            min-height: 340px;
        }

        .rooms-hero-text {
            padding: 60px 48px;
            display: flex;
            flex-direction: column;
            justify-content: center;
        }

        .rooms-hero-eyebrow {
            font-family: 'Jost', sans-serif;
            font-size: 13px;
            letter-spacing: 3px;
            color: #d4af37;
            margin-bottom: 18px;
            text-transform: uppercase;
        }

        .rooms-hero-text h1 {
            font-family: 'Playfair Display', serif;
            font-size: 42px;
            font-weight: 600;
            color: #fdfbf7;
            line-height: 1.25;
            margin-bottom: 20px;
        }

        .rooms-hero-text p {
            font-family: 'Jost', sans-serif;
            font-size: 15px;
            line-height: 1.85;
            color: #c9beac;
            max-width: 480px;
            margin: 0;
        }

        .rooms-hero-photo {
            position: relative;
            min-height: 260px;
        }

        .rooms-hero-photo img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            display: block;
        }

        @media (max-width: 860px) {
            .rooms-hero-inner {
                grid-template-columns: 1fr;
            }

            .rooms-hero-text {
                padding: 46px 24px 34px;
            }

            .rooms-hero-text h1 {
                font-size: 30px;
            }

            .rooms-hero-photo {
                min-height: 220px;
            }
        }

        /* ===========================
           FILTER PILLS
        =========================== */

        .rooms-filter-bar {
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
            gap: 12px;
            padding: 48px 24px 12px;
            max-width: 1100px;
            margin: 0 auto;
        }

        .rooms-filter-btn {
            font-family: 'Jost', sans-serif;
            font-size: 14px;
            color: #2b2621;
            background: #fff;
            border: 1px solid #e7ddca;
            padding: 10px 24px;
            border-radius: 30px;
            cursor: pointer;
            transition: all 0.2s ease;
        }

        .rooms-filter-btn:hover {
            border-color: #2b2621;
        }

        .rooms-filter-btn.active {
            background: #1c1712;
            border-color: #1c1712;
            color: #fdfbf7;
        }

        /* ===========================
           ROOM CARD GRID
        =========================== */

        .rooms-grid-wrap {
            max-width: 1400px;
            margin: 0 auto;
            padding: 30px 24px 10px;
        }

        .rooms-grid {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 28px;
        }

        @media (max-width: 1200px) {
            .rooms-grid {
                grid-template-columns: repeat(2, 1fr);
            }
        }

        @media (max-width: 560px) {
            .rooms-grid {
                grid-template-columns: 1fr;
            }
        }

        .room-card {
            background: #fff;
            border: 1px solid #ece3d2;
            border-radius: 12px;
            overflow: hidden;
            transition: transform .25s ease, box-shadow .25s ease;
            display: flex;
            flex-direction: column;
        }

        .room-card:hover {
            transform: translateY(-4px);
            box-shadow: 0 16px 34px rgba(43, 38, 33, .1);
        }

        .room-card-photo {
            height: 200px;
            overflow: hidden;
            position: relative;
        }

        .room-card-photo img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: transform .5s ease;
        }

        .room-card:hover .room-card-photo img {
            transform: scale(1.06);
        }

        .room-card-status {
            position: absolute;
            top: 14px;
            right: 14px;
            font-family: 'Jost', sans-serif;
            font-size: 10.5px;
            letter-spacing: .5px;
            padding: 5px 12px;
            border-radius: 20px;
            background: rgba(255, 255, 255, .92);
            color: #4f7a4a;
        }

        .room-card-status.is-booked {
            color: #b3532b;
        }

        .room-card-body {
            padding: 20px 20px 22px;
            display: flex;
            flex-direction: column;
            flex: 1;
        }

        .room-card-body h3 {
            font-family: 'Playfair Display', serif;
            font-size: 20px;
            font-weight: 600;
            color: #2b2621;
            margin: 0 0 4px;
        }

        .room-card-subtitle {
            font-family: 'Jost', sans-serif;
            font-size: 12.5px;
            color: #a9825c;
            margin-bottom: 14px;
        }

        .room-card-meta {
            display: flex;
            flex-wrap: wrap;
            gap: 14px;
            margin-bottom: 14px;
        }

        .room-card-meta span {
            display: flex;
            align-items: center;
            gap: 6px;
            font-family: 'Jost', sans-serif;
            font-size: 12.5px;
            color: #8a7f6f;
        }

        .room-card-meta i {
            color: #a9825c;
            font-size: 12px;
        }

        .room-card-desc {
            font-family: 'Jost', sans-serif;
            font-size: 13px;
            line-height: 1.7;
            color: #8a7f6f;
            margin-bottom: 18px;
            flex: 1;
        }

        .room-card-footer {
            display: flex;
            align-items: center;
            justify-content: space-between;
            border-top: 1px solid #ece3d2;
            padding-top: 16px;
        }

        .room-card-price {
            font-family: 'Playfair Display', serif;
            font-size: 20px;
            color: #2b2621;
        }

        .room-card-price small {
            font-family: 'Jost', sans-serif;
            font-size: 12px;
            color: #a89a84;
            font-weight: 400;
        }

        .room-card-btn {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            background: #d4af37;
            color: #2b2621;
            font-family: 'Jost', sans-serif;
            font-size: 13px;
            font-weight: 600;
            padding: 10px 18px;
            border-radius: 8px;
            text-decoration: none;
            transition: background .2s ease;
        }

        .room-card-btn:hover {
            background: #b8921f;
            color: #2b2621;
        }

        .room-card-btn.is-disabled {
            background: #e7ddca;
            color: #a89a84;
            pointer-events: none;
        }

        /* ===========================
           TRUST STRIP
        =========================== */

        .rooms-highlights {
            background: #f5f0e6;
            margin-top: 60px;
            padding: 44px 24px;
        }

        .rooms-highlights-inner {
            max-width: 1100px;
            margin: 0 auto;
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 30px;
        }

        @media (max-width: 768px) {
            .rooms-highlights-inner {
                grid-template-columns: repeat(2, 1fr);
            }
        }

        .rooms-highlight-item {
            display: flex;
            align-items: center;
            gap: 14px;
        }

        .rooms-highlight-item i {
            font-size: 20px;
            color: #2b2621;
            width: 22px;
            text-align: center;
        }

        .rooms-highlight-item strong {
            display: block;
            font-family: 'Jost', sans-serif;
            font-size: 14px;
            color: #2b2621;
            font-weight: 600;
        }

        .rooms-highlight-item span {
            font-family: 'Jost', sans-serif;
            font-size: 12.5px;
            color: #8a7f6f;
        }

        .rooms-empty {
            text-align: center;
            font-family: 'Jost', sans-serif;
            color: #8a7f6f;
            padding: 60px 24px;
            display: none;
        }
        
    </style>
@endpush

@section('content')

    @php
        $roomTypeNames = $rooms->map(fn($room) => optional($room->roomType)->name)
            ->filter()
            ->unique()
            ->values();
    @endphp

    <section class="rooms-hero">
        <div class="rooms-hero-inner">

            <div class="rooms-hero-text">
                <span class="rooms-hero-eyebrow">Our Rooms</span>
                <h1>Comfortable Stays,<br>Unforgettable Experiences</h1>
                <p>
                    Discover our beautifully designed rooms, crafted for your comfort and
                    relaxation. Whether you're here for business or leisure, Hotel Luxura
                    offers the perfect stay for every guest.
                </p>
            </div>

            <div class="rooms-hero-photo">
                <img src="{{ asset('frontend/images/see.jfif') }}" alt="Hotel Room">
            </div>

        </div>
    </section>

    <div class="rooms-filter-bar" id="roomsFilterBar">
        <button type="button" class="rooms-filter-btn active" data-filter="all">All Rooms</button>

        @foreach($roomTypeNames as $typeName)
            <button type="button" class="rooms-filter-btn" data-filter="{{ Str::slug($typeName) }}">
                {{ $typeName }}
            </button>
        @endforeach
    </div>

    <div class="rooms-grid-wrap">
        <div class="rooms-grid" id="roomsGrid">

            @foreach($rooms as $room)

                <div class="room-card" data-type="{{ Str::slug(optional($room->roomType)->name) }}">

                    <div class="room-card-photo">

                        @if($room->image)
                            <img src="{{ $room->image }}" alt="{{ optional($room->roomType)->name }}">
                        @elseif(optional($room->roomType)->image)
                            <img src="{{ Str::startsWith($room->roomType->image, ['http://', 'https://']) ? $room->roomType->image : asset('storage/' . $room->roomType->image) }}"
                                alt="{{ $room->roomType->name }}">
                            <img src="{{ asset('images/default-room.jpg') }}" alt="{{ optional($room->roomType)->name }}">
                        @endif

                        @if($room->status)
                            <span class="room-card-status">Available</span>
                        @else
                            <span class="room-card-status is-booked">Booked</span>
                        @endif

                    </div>

                    <div class="room-card-body">

                        <h3>{{ optional($room->roomType)->name ?? 'Room' }}</h3>
                        <div class="room-card-subtitle">Room {{ $room->room_number }} &middot; Floor {{ $room->floor ?? 'N/A' }}
                        </div>

                        <div class="room-card-meta">
                            <span><i class="fas fa-user-friends"></i> {{ optional($room->roomType)->capacity ?? '-' }}
                                Guests</span>

                            @foreach($room->amenities->take(2) as $amenity)
                                <span><i class="fas fa-check"></i> {{ $amenity->name }}</span>
                            @endforeach
                        </div>

                        <p class="room-card-desc">
                            {{ Str::limit(optional($room->roomType)->description ?? 'A thoughtfully designed room offering comfort and elegance.', 90) }}
                        </p>

                        <div class="room-card-footer">

                            <div class="room-card-price">
                                ₹{{ number_format(optional($room->roomType)->price ?? 0, 0) }}
                                <small>/ night</small>
                            </div>

                            @if($room->status)
                                <a href="{{ route('frontend.room.show', $room->id) }}" class="room-card-btn">
                                    <i class="fas fa-calendar-alt"></i> Book Now
                                </a>
                            @else
                                <span class="room-card-btn is-disabled">
                                    <i class="fas fa-calendar-alt"></i> Booked
                                </span>
                            @endif

                        </div>

                    </div>

                </div>

            @endforeach

        </div>

        <div class="rooms-empty" id="roomsEmpty">
            No rooms found in this category right now.
        </div>
    </div>

    <section class="rooms-highlights">
        <div class="rooms-highlights-inner">

            <div class="rooms-highlight-item">
                <i class="fas fa-concierge-bell"></i>
                <div>
                    <strong>24/7 Room Service</strong>
                    <span>Your comfort, our priority</span>
                </div>
            </div>

            <div class="rooms-highlight-item">
                <i class="fas fa-shield-alt"></i>
                <div>
                    <strong>Secure &amp; Safe</strong>
                    <span>A safe stay, always</span>
                </div>
            </div>

            <div class="rooms-highlight-item">
                <i class="fas fa-wifi"></i>
                <div>
                    <strong>Free Wi-Fi</strong>
                    <span>Stay connected</span>
                </div>
            </div>

            <div class="rooms-highlight-item">
                <i class="fas fa-map-marker-alt"></i>
                <div>
                    <strong>Prime Location</strong>
                    <span>Close to top attractions</span>
                </div>
            </div>

        </div>
    </section>

@endsection

@push('after-scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const filterButtons = document.querySelectorAll('#roomsFilterBar .rooms-filter-btn');
            const roomCards = document.querySelectorAll('#roomsGrid .room-card');
            const emptyState = document.getElementById('roomsEmpty');

            filterButtons.forEach(function (button) {
                button.addEventListener('click', function () {
                    filterButtons.forEach(b => b.classList.remove('active'));
                    button.classList.add('active');

                    const filter = button.getAttribute('data-filter');
                    let visibleCount = 0;

                    roomCards.forEach(function (card) {
                        if (filter === 'all' || card.getAttribute('data-type') === filter) {
                            card.style.display = '';
                            visibleCount++;
                        } else {
                            card.style.display = 'none';
                        }
                    });

                    emptyState.style.display = visibleCount === 0 ? 'block' : 'none';
                });
            });
        });
    </script>
@endpush