@extends('frontend.layouts.app')

@section('title', 'Hotel Amenities')

@section('content')

<style>
    /* =========================================================
       HOTEL LUXURA — AMENITIES PAGE
       ========================================================= */

    :root {
        --lux-dark: #25211d;
        --lux-brown: #4a4034;
        --lux-brown-light: #6b5a48;
        --lux-gold: #a9825c;
        --lux-gold-soft: #c6a477;
        --lux-cream: #f7f3ec;
        --lux-white: #fffdf9;
        --lux-muted: #82776a;
        --lux-border: #e8e0d4;
    }

    /* =========================================================
       PAGE
       ========================================================= */

    .amenities-page {
        background: var(--lux-white);
        color: var(--lux-dark);
    }

    /* =========================================================
       HERO
       ========================================================= */

    .amenities-hero {
        position: relative;
        min-height: 62vh;
        width: 100%;
        display: flex;
        align-items: center;
        justify-content: center;
        overflow: hidden;

        background:
            linear-gradient(
                180deg,
                rgba(25, 21, 18, .38) 0%,
                rgba(25, 21, 18, .72) 100%
            ),
            url('{{ asset("frontend/images/images (7).jfif") }}')
            center center / cover no-repeat;
    }

    .amenities-hero::after {
        content: "";
        position: absolute;
        inset: 0;
        background: linear-gradient(
            90deg,
            rgba(20, 17, 14, .28),
            transparent 50%,
            rgba(20, 17, 14, .22)
        );
        pointer-events: none;
    }

    .amenities-hero-inner {
        position: relative;
        z-index: 2;
        max-width: 850px;
        padding: 80px 20px 60px;
    }

    .hero-badge {
        display: inline-flex;
        align-items: center;
        gap: 10px;

        padding: 9px 20px;

        border: 1px solid rgba(231, 211, 180, .65);
        color: #f3e8d8;

        font-size: 11px;
        font-weight: 700;
        letter-spacing: 2.5px;
        text-transform: uppercase;

        background: rgba(37, 33, 29, .22);
        backdrop-filter: blur(5px);
    }

    .hero-badge::before,
    .hero-badge::after {
        content: "✦";
        color: var(--lux-gold-soft);
        font-size: 10px;
    }

    .amenities-hero h1 {
        margin: 25px 0 18px;

        font-family: 'Playfair Display', Georgia, serif;
        font-size: clamp(3rem, 6vw, 5.2rem);
        font-weight: 600;
        line-height: 1.05;

        color: #fffdf8;
        letter-spacing: -1px;
    }

    .amenities-hero p {
        max-width: 650px;
        margin: 0 auto;

        color: #e9dfd1;
        font-size: 17px;
        line-height: 1.8;
        font-weight: 400;
    }

    /* =========================================================
       INTRO
       ========================================================= */

    .amenities-intro {
        padding: 95px 20px 75px;
        text-align: center;
    }

    .section-title {
        position: relative;
        display: inline-flex;
        align-items: center;
        gap: 12px;

        color: var(--lux-gold);
        font-size: 11px;
        font-weight: 700;
        letter-spacing: 3px;
        text-transform: uppercase;
    }

    .section-title::before,
    .section-title::after {
        content: "";
        width: 24px;
        height: 1px;
        background: var(--lux-gold);
    }

    .section-heading {
        margin: 16px 0 14px;

        font-family: 'Playfair Display', Georgia, serif;
        font-size: clamp(2rem, 4vw, 3.1rem);
        font-weight: 600;
        line-height: 1.2;

        color: var(--lux-dark);
    }

    .section-sub {
        max-width: 650px;
        margin: 0 auto;

        color: var(--lux-muted);
        font-size: 15px;
        line-height: 1.9;
    }

    /* =========================================================
       AMENITIES LIST
       ========================================================= */

    .amenities-list {
        padding-bottom: 90px;
    }

    .amenity-zigzag-row {
        position: relative;
        margin-bottom: 90px;
    }

    /* =========================================================
       IMAGE
       ========================================================= */

    .amenity-zigzag-image {
        position: relative;
        overflow: hidden;
        background: #eee7dc;
    }

    .amenity-zigzag-image::after {
        content: "";
        position: absolute;
        inset: 16px;

        border: 1px solid rgba(255, 255, 255, .45);

        pointer-events: none;
        transition: .4s ease;
    }

    .amenity-zigzag-image img {
        width: 100%;
        height: 390px;

        display: block;
        object-fit: cover;

        transition:
            transform .7s ease,
            filter .5s ease;
    }

    .amenity-zigzag-row:hover .amenity-zigzag-image img {
        transform: scale(1.035);
        filter: brightness(.94);
    }

    /* =========================================================
       CONTENT
       ========================================================= */

    .amenity-zigzag-content {
        padding: 20px 55px;
    }

    .amenity-zigzag-row:nth-child(even) .amenity-zigzag-content {
        padding-left: 55px;
    }

    .amenity-zigzag-icon {
        width: 58px;
        height: 58px;

        display: flex;
        align-items: center;
        justify-content: center;

        margin-bottom: 20px;

        border: 1px solid var(--lux-gold);
        border-radius: 50%;

        color: var(--lux-gold);
        background: #fffdf9;

        font-size: 20px;

        box-shadow: 0 8px 25px rgba(55, 44, 33, .06);
    }

    .amenity-badge-tag {
        display: inline-block;

        margin-bottom: 14px;
        padding: 6px 13px;

        background: #f1e8dc;
        color: var(--lux-brown-light);

        font-size: 10px;
        font-weight: 700;
        letter-spacing: 1.4px;
        text-transform: uppercase;
    }

    .amenity-zigzag-content h3 {
        position: relative;

        margin: 0 0 17px;

        font-family: 'Playfair Display', Georgia, serif;
        font-size: 31px;
        font-weight: 600;

        color: var(--lux-dark);
    }

    .amenity-zigzag-content h3::after {
        content: "";

        display: block;

        width: 38px;
        height: 2px;

        margin-top: 12px;

        background: var(--lux-gold);
    }

    .amenity-zigzag-content p {
        max-width: 500px;
        margin: 0;

        color: var(--lux-muted);
        font-size: 15px;
        line-height: 1.9;
    }

    /* =========================================================
       NUMBER
       ========================================================= */

    .amenity-number {
        margin-top: 25px;

        color: #b7aa9b;
        font-family: 'Playfair Display', Georgia, serif;
        font-size: 13px;
        letter-spacing: 2px;
    }

    /* =========================================================
       BOTTOM CTA
       ========================================================= */

    .amenities-cta {
        position: relative;

        margin-top: 10px;
        padding: 85px 20px;

        background:
            linear-gradient(
                rgba(37, 33, 29, .92),
                rgba(37, 33, 29, .92)
            ),
            url('{{ asset("frontend/images/images (7).jfif") }}')
            center / cover no-repeat;

        text-align: center;
    }

    .amenities-cta small {
        display: block;

        margin-bottom: 14px;

        color: var(--lux-gold-soft);
        font-size: 11px;
        font-weight: 700;
        letter-spacing: 3px;
        text-transform: uppercase;
    }

    .amenities-cta h2 {
        margin-bottom: 15px;

        color: #fffdf9;

        font-family: 'Playfair Display', Georgia, serif;
        font-size: clamp(2rem, 4vw, 3.2rem);
        font-weight: 600;
    }

    .amenities-cta p {
        max-width: 600px;
        margin: 0 auto 28px;

        color: #d7cbbd;
        line-height: 1.8;
        font-size: 15px;
    }

    .amenities-cta-btn {
        display: inline-flex;
        align-items: center;
        justify-content: center;

        padding: 12px 28px;

        border: 1px solid var(--lux-gold-soft);

        color: #f6ead9;
        background: transparent;

        font-size: 11px;
        font-weight: 700;
        letter-spacing: 1.8px;
        text-transform: uppercase;
        text-decoration: none;

        transition: .3s ease;
    }

    .amenities-cta-btn:hover {
        background: var(--lux-gold);
        border-color: var(--lux-gold);
        color: #fff;
        text-decoration: none;
    }

    /* =========================================================
       RESPONSIVE
       ========================================================= */

    @media (max-width: 991.98px) {

        .amenities-hero {
            min-height: 55vh;
        }

        .amenity-zigzag-content,
        .amenity-zigzag-row:nth-child(even) .amenity-zigzag-content {
            padding: 30px 15px;
        }

        .amenity-zigzag-image img {
            height: 320px;
        }

        .amenity-zigzag-row {
            margin-bottom: 65px;
        }
    }

    @media (max-width: 767.98px) {

        .amenities-hero {
            min-height: 52vh;
        }

        .amenities-hero-inner {
            padding: 70px 18px 45px;
        }

        .amenities-hero h1 {
            font-size: 2.8rem;
        }

        .amenities-hero p {
            font-size: 14px;
        }

        .amenities-intro {
            padding: 70px 18px 55px;
        }

        .amenity-zigzag-row {
            margin-bottom: 55px;
        }

        .amenity-zigzag-image img {
            height: 250px;
        }

        .amenity-zigzag-image::after {
            inset: 10px;
        }

        .amenity-zigzag-content,
        .amenity-zigzag-row:nth-child(even) .amenity-zigzag-content {
            padding: 25px 5px 5px;
        }

        .amenity-zigzag-content h3 {
            font-size: 26px;
        }

        .amenity-zigzag-content p {
            font-size: 14px;
        }

        .amenities-cta {
            padding: 65px 20px;
        }
    }
</style>

<div class="amenities-page">

    {{-- ================= HERO ================= --}}
    <section class="amenities-hero">

        <div class="amenities-hero-inner text-center">

            <span class="hero-badge">
                Luxury Experience
            </span>

            <h1>
                Hotel Amenities
            </h1>

            <p>
                Thoughtfully designed facilities and services
                created to make every moment of your stay comfortable,
                relaxing and memorable.
            </p>

        </div>

    </section>


    {{-- ================= INTRO ================= --}}
    <section class="amenities-intro">

        <span class="section-title">
            Premium Facilities
        </span>

        <h2 class="section-heading">
            Designed For Your Comfort
        </h2>

        <p class="section-sub">
            From wellness and dining to effortless everyday conveniences,
            discover everything Hotel Luxura has prepared for your stay.
        </p>

    </section>


    {{-- ================= AMENITIES ================= --}}
    <section class="amenities-list">

        <div class="container">

            @php
                $amenities = [
                    [
                        'wifi',
                        'Free WiFi',
                        'Complimentary',
                        'Stay connected with high-speed complimentary WiFi available throughout the hotel, from your room to every common area.',
                        'https://images.unsplash.com/photo-1521737604893-d14cc237f11d?w=900'
                    ],
                    [
                        'swimming-pool',
                        'Swimming Pool',
                        'Premium',
                        'Unwind at our outdoor infinity pool, surrounded by loungers and scenic views. Open through the day for a refreshing escape.',
                        'https://images.unsplash.com/photo-1571003123894-1f0594d2b5d9?w=900'
                    ],
                    [
                        'dumbbell',
                        'Fitness Gym',
                        '24/7',
                        'Stay on track with modern, fully equipped gym facilities available around the clock for every guest.',
                        'https://images.unsplash.com/photo-1534438327276-14e5300c3a48?w=900'
                    ],
                    [
                        'utensils',
                        'Restaurant',
                        'Fine Dining',
                        'Savour multi-cuisine fine dining crafted by our expert chefs, from local delicacies to international favourites.',
                        'https://images.unsplash.com/photo-1517248135467-4c7edcad34c4?w=900'
                    ],
                    [
                        'spa',
                        'Luxury Spa',
                        'Wellness',
                        'Rejuvenate your senses with our professional spa treatments, designed to melt away stress and restore balance.',
                        'https://images.unsplash.com/photo-1544161515-4ab6ce6db874?w=900'
                    ],
                    [
                        'car',
                        'Free Parking',
                        'Secure',
                        'Enjoy the convenience of secure, complimentary parking available for every guest throughout their stay.',
                        'https://images.unsplash.com/photo-1506521781263-d8422e82f27a?w=900'
                    ],
                    [
                        'concierge-bell',
                        'Room Service',
                        '24/7',
                        'Order from our curated menu anytime with attentive, round-the-clock in-room dining service.',
                        'https://images.unsplash.com/photo-1584132967334-10e028bd69f7?w=900'
                    ],
                    [
                        'cocktail',
                        'Bar Lounge',
                        'Premium',
                        'End your day with handcrafted cocktails and premium drinks in an intimate lounge setting, perfect for relaxed evenings.',
                        'https://images.unsplash.com/photo-1470337458703-46ad1756a187?w=900'
                    ],
                ];
            @endphp


            @foreach($amenities as $index => $item)

                <div class="row align-items-center amenity-zigzag-row {{ $index % 2 == 1 ? 'flex-row-reverse' : '' }}">

                    {{-- IMAGE --}}
                    <div class="col-lg-6">

                        <div class="amenity-zigzag-image">

                            <img
                                src="{{ $item[4] }}"
                                alt="{{ $item[1] }}"
                                loading="lazy"
                            >

                        </div>

                    </div>


                    {{-- CONTENT --}}
                    <div class="col-lg-6">

                        <div class="amenity-zigzag-content">

                            <div class="amenity-zigzag-icon">
                                <i class="fas fa-{{ $item[0] }}"></i>
                            </div>

                            <span class="amenity-badge-tag">
                                {{ $item[2] }}
                            </span>

                            <h3>
                                {{ $item[1] }}
                            </h3>

                            <p>
                                {{ $item[3] }}
                            </p>

                            <div class="amenity-number">
                                0{{ $index + 1 }}
                            </div>

                        </div>

                    </div>

                </div>

            @endforeach

        </div>

    </section>


    {{-- ================= CTA ================= --}}
    <section class="amenities-cta">

        <small>
            Hotel Luxura
        </small>

        <h2>
            Everything You Need, Beautifully Delivered
        </h2>

        <p>
            Settle in, slow down and enjoy a stay designed around
            comfort, convenience and memorable experiences.
        </p>

        <a href="{{ route('frontend.reservation.index') }}" class="amenities-cta-btn">
            Plan Your Stay
        </a>

    </section>

</div>

@endsection