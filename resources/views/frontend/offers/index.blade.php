@extends('frontend.layouts.app')

@section('title', 'Offers')

@push('after-styles')
<style>
    /* ===========================
       OFFERS HERO
    =========================== */

    .offers-hero {
        position: relative;
        width: 100%;
        min-height: 38vh;
        display: flex;
        align-items: center;
        justify-content: center;
        background:
            linear-gradient(180deg, rgba(43,38,33,.55) 0%, rgba(43,38,33,.80) 100%),
            url('https://images.unsplash.com/photo-1590073844006-33379778ae09?w=1600') center/cover no-repeat;
        text-align: center;
        margin-bottom: 60px;
    }

    .offers-hero span.kicker {
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

    .offers-hero h1 {
        font-family: 'Playfair Display', serif;
        font-size: clamp(2.2rem, 5vw, 3.4rem);
        font-weight: 700;
        color: #fffdfa;
        margin: 0 0 12px;
    }

    .offers-hero p {
        max-width: 560px;
        margin: 0 auto;
        color: #e8dcc8;
        font-size: 16px;
        line-height: 1.8;
    }

    /* ===========================
       MAGAZINE TILE GRID
    =========================== */

    .magazine-grid-section {
        padding: 0 0 90px;
        background: #f7f2ea;
    }

    .magazine-grid {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 24px;
    }

    .magazine-tile {
        border-radius: 18px;
        overflow: hidden;
        padding: 44px 40px;
        display: flex;
        flex-direction: column;
        justify-content: space-between;
        min-height: 340px;
        position: relative;
    }

    .magazine-tile.tile-light {
        background: #fffdfa;
        border: 1px solid #e5dccb;
    }

    .magazine-tile.tile-dark {
        background: #2b2621;
        color: #f0e6d4;
    }

    .magazine-tile-text h3 {
        font-family: 'Playfair Display', serif;
        font-size: 30px;
        font-weight: 700;
        line-height: 1.2;
        margin-bottom: 14px;
    }

    .magazine-tile.tile-light .magazine-tile-text h3 {
        color: #2b2621;
    }

    .magazine-tile.tile-dark .magazine-tile-text h3 {
        color: #fffdfa;
    }

    .magazine-tile-text p {
        font-size: 14.5px;
        line-height: 1.75;
        max-width: 320px;
        margin-bottom: 20px;
    }

    .magazine-tile.tile-light .magazine-tile-text p {
        color: #8a7f6f;
    }

    .magazine-tile.tile-dark .magazine-tile-text p {
        color: #d9c4a5;
    }

    .magazine-tile-link {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        font-size: 13px;
        font-weight: 700;
        letter-spacing: 0.06em;
        text-transform: uppercase;
        text-decoration: none;
        transition: gap 0.25s;
    }

    .magazine-tile.tile-light .magazine-tile-link {
        color: #a9825c;
    }

    .magazine-tile.tile-dark .magazine-tile-link {
        color: #d9c4a5;
    }

    .magazine-tile-link:hover {
        gap: 13px;
        text-decoration: none;
    }

    .magazine-tile.tile-light .magazine-tile-link:hover {
        color: #8a6844;
    }

    .magazine-tile.tile-dark .magazine-tile-link:hover {
        color: #fffdfa;
    }

    .magazine-tile-image {
        margin-top: 24px;
        border-radius: 12px;
        overflow: hidden;
    }

    .magazine-tile-image img {
        width: 100%;
        height: 150px;
        object-fit: cover;
        display: block;
    }

    /* photo strip for Suites tile */
    .magazine-tile-strip {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: 10px;
        margin-top: 24px;
    }

    .magazine-tile-strip img {
        width: 100%;
        height: 130px;
        object-fit: cover;
        border-radius: 10px;
    }

    /* mini offer cards inside dark tile */
    .magazine-mini-cards {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 14px;
        margin-top: 20px;
    }

    .magazine-mini-card {
        background: rgba(255,255,255,0.06);
        border: 1px solid rgba(255,255,255,0.12);
        border-radius: 10px;
        overflow: hidden;
    }

    .magazine-mini-card img {
        width: 100%;
        height: 90px;
        object-fit: cover;
        display: block;
    }

    .magazine-mini-card span {
        display: block;
        padding: 10px 12px;
        font-size: 12.5px;
        color: #f0e6d4;
        font-weight: 500;
    }

    @media (max-width: 900px) {
        .magazine-grid {
            grid-template-columns: 1fr;
        }

        .magazine-tile {
            padding: 34px 26px;
            min-height: auto;
        }
    }

    /* ===========================
       ZIGZAG DETAIL SECTIONS
    =========================== */

    .offer-zigzag-row {
        margin-bottom: 46px;
    }

    .offer-zigzag-image img {
        width: 100%;
        height: 320px;
        object-fit: cover;
        border-radius: 16px;
    }

    .offer-zigzag-content {
        padding: 26px 36px;
    }

    .offer-zigzag-content .offer-label {
        display: inline-block;
        background: #f0e6d4;
        color: #6b5a3e;
        border-radius: 999px;
        padding: 5px 14px;
        font-size: 11px;
        font-weight: 700;
        letter-spacing: 0.08em;
        text-transform: uppercase;
        margin-bottom: 14px;
    }

    .offer-zigzag-content h3 {
        font-family: 'Playfair Display', serif;
        color: #2b2621;
        font-size: 26px;
        font-weight: 700;
        margin-bottom: 12px;
    }

    .offer-zigzag-content p {
        color: #8a7f6f;
        font-size: 15px;
        line-height: 1.8;
        margin-bottom: 20px;
    }

    .theme-btn {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        background: #a9825c;
        color: #fff;
        border-radius: 8px;
        padding: 11px 24px;
        font-weight: 600;
        font-size: 13px;
        letter-spacing: 0.03em;
        text-transform: uppercase;
        text-decoration: none;
        transition: 0.25s ease;
    }

    .theme-btn:hover {
        background: #8a6844;
        color: #fff;
        text-decoration: none;
    }

    @media (max-width: 767.98px) {
        .offer-zigzag-content {
            padding: 22px 16px;
        }

        .offer-zigzag-image img {
            height: 240px;
        }
    }
</style>
@endpush

@section('content')

    <section class="offers-hero page-hero">
        <div class="container">
            <span class="kicker">Exclusive Savings</span>
            <h1>Hotel Offers</h1>
            <p>Enjoy curated stays, seasonal deals, and premium experiences designed for your next unforgettable getaway.</p>
        </div>
    </section>

    <section class="magazine-grid-section">
        <div class="container">

            <div class="magazine-grid">

                <!-- Tile 1: Dining -->
                <div class="magazine-tile tile-light">
                    <div class="magazine-tile-text">
                        <h3>Elegance at the Heart of Dining</h3>
                        <p>Savour a curated menu of fine cuisine, crafted by our expert chefs in an atmosphere of quiet luxury.</p>
                        <a href="{{ route('frontend.services') }}" class="magazine-tile-link">Discover More &rarr;</a>
                    </div>
                    <div class="magazine-tile-image">
                        <img src="https://images.unsplash.com/photo-1517248135467-4c7edcad34c4?w=700" alt="Fine Dining">
                    </div>
                </div>

                <!-- Tile 2: Weddings -->
                <div class="magazine-tile tile-dark">
                    <div class="magazine-tile-text">
                        <h3>Palace Weddings in Luxury</h3>
                        <p>A wedding remembered for a lifetime — bespoke décor, fine dining and a setting fit for royalty.</p>
                        <a href="{{ route('frontend.contact') }}" class="magazine-tile-link">Discover More &rarr;</a>
                    </div>
                    <div class="magazine-tile-image">
                        <img src="https://images.unsplash.com/photo-1519741497674-611481863552?w=700" alt="Palace Wedding">
                    </div>
                </div>

                <!-- Tile 3: Suites and Rooms -->
                <div class="magazine-tile tile-light">
                    <div class="magazine-tile-text">
                        <h3>Suites and Rooms</h3>
                        <p>Timeless interiors, thoughtful comfort and stay options tailored for every guest.</p>
                        <a href="{{ route('frontend.room.index') }}" class="magazine-tile-link">Discover More &rarr;</a>
                    </div>
                    <div class="magazine-tile-strip">
                        <img src="https://images.unsplash.com/photo-1590490360182-c33d57733427?w=300" alt="Room 1">
                        <img src="https://images.unsplash.com/photo-1582719478250-c89cae4dc85b?w=300" alt="Room 2">
                        <img src="https://images.unsplash.com/photo-1591088398332-8a7791972843?w=300" alt="Room 3">
                        <img src="https://images.unsplash.com/photo-1578683010236-d716f9a3f461?w=300" alt="Room 4">
                    </div>
                </div>

                <!-- Tile 4: Packages and Offers -->
                <div class="magazine-tile tile-dark">
                    <div class="magazine-tile-text">
                        <h3>Packages and Offers</h3>
                        <p>Seasonal packages designed around romance, wellness and unforgettable celebrations.</p>
                    </div>
                    <div class="magazine-mini-cards">
                        <div class="magazine-mini-card">
                            <img src="https://images.unsplash.com/photo-1529333166437-7750a6dd5a70?w=300" alt="Palace Love Story">
                            <span>A Palace Love Story</span>
                        </div>
                        <div class="magazine-mini-card">
                            <img src="https://images.unsplash.com/photo-1544161515-4ab6ce6db874?w=300" alt="Spa Wellness Package">
                            <span>Spa &amp; Wellness Package</span>
                        </div>
                    </div>
                </div>

            </div>

        </div>
    </section>

    <section class="offers-wrapper" style="background:#fffdfa; padding-bottom: 90px;">
        <div class="container">

            <div class="text-center mb-5">
                <span class="section-subtitle" style="color:#a9825c; font-size:13px; letter-spacing:3px; font-weight:700; text-transform:uppercase;">Current Deals</span>
                <h2 style="font-family:'Playfair Display', serif; color:#2b2621; font-weight:700; margin-top:10px;">Explore Our Offers</h2>
            </div>

            @php
                $offers = [
                    [
                        'label' => 'Offer',
                        'title' => 'Summer Escape Deal',
                        'text' => 'Get up to 20% off on deluxe rooms with complimentary breakfast, free Wi-Fi, and late checkout.',
                        'image' => 'https://images.unsplash.com/photo-1566073771259-6a8506099945?w=900',
                    ],
                    [
                        'label' => 'Featured',
                        'title' => 'Weekend Luxury Stay',
                        'text' => 'Includes free airport pickup, a spa session, and a curated welcome package for two.',
                        'image' => 'https://images.unsplash.com/photo-1611892440504-42a792e24d32?w=900',
                    ],
                    [
                        'label' => 'Member Benefit',
                        'title' => 'Long Stay Rewards',
                        'text' => 'Enjoy exclusive value on extended stays, room upgrades, and personalized concierge calls.',
                        'image' => 'https://images.unsplash.com/photo-1571896349842-33c89424de2d?w=900',
                    ],
                ];
            @endphp

            @foreach($offers as $index => $offer)

                <div class="row align-items-center offer-zigzag-row {{ $index % 2 == 1 ? 'flex-row-reverse' : '' }}">

                    <div class="col-lg-6">
                        <div class="offer-zigzag-image">
                            <img src="{{ $offer['image'] }}" alt="{{ $offer['title'] }}">
                        </div>
                    </div>

                    <div class="col-lg-6">
                        <div class="offer-zigzag-content">
                            <span class="offer-label">{{ $offer['label'] }}</span>
                            <h3>{{ $offer['title'] }}</h3>
                            <p>{{ $offer['text'] }}</p>
                            <a href="{{ route('frontend.contact') }}" class="theme-btn">Book This Offer</a>
                        </div>
                    </div>

                </div>

            @endforeach

        </div>
    </section>

@endsection