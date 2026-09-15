@extends('frontend.layouts.app')

@section('title', 'Hotel Amenities')

@section('content')
<style>

    /* ===========================
       HERO
    =========================== */

    .amenities-hero {
        position: relative;
        min-height: 60vh;
        width: 100%;
        margin-top: -24px;
        background:
            linear-gradient(180deg, rgba(43,38,33,.55) 0%, rgba(43,38,33,.78) 100%),
            url('{{ asset("frontend/images/amenities.jpg") }}') center/cover no-repeat;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .hero-badge {
        display: inline-block;
        padding: 10px 26px;
        border: 1px solid #d9c4a5;
        color: #f0e6d4;
        border-radius: 30px;
        letter-spacing: 2px;
        font-size: 13px;
        font-weight: 600;
    }

    .amenities-hero h1 {
        font-family: 'Playfair Display', serif;
        font-size: clamp(2.5rem, 5vw, 4.2rem);
        font-weight: 700;
        line-height: 1.15;
        color: #fffdfa;
        margin: 22px 0 16px;
    }

    .amenities-hero p {
        max-width: 620px;
        margin: 0 auto;
        line-height: 1.8;
        color: #e8dcc8;
        font-size: 17px;
    }

    @media (max-width: 767.98px) {
        .amenities-hero {
            min-height: 46vh;
        }

        .amenities-hero p {
            font-size: 15px;
        }
    }

    /* ===========================
       SECTION HEADING
    =========================== */

    .section-title {
        color: #a9825c;
        letter-spacing: 3px;
        font-weight: 700;
        font-size: 13px;
        text-transform: uppercase;
    }

    .section-heading {
        font-family: 'Playfair Display', serif;
        color: #2b2621;
        font-weight: 700;
        margin-top: 12px;
    }

    .section-sub {
        color: #8a7f6f;
        max-width: 600px;
        margin: 14px auto 0;
    }

    /* ===========================
       ZIGZAG AMENITY ROWS
    =========================== */

    .amenity-zigzag-row {
        margin-bottom: 40px;
    }

    .amenity-zigzag-image img {
        width: 100%;
        height: 340px;
        object-fit: cover;
        border-radius: 14px;
    }

    .amenity-zigzag-content {
        padding: 30px 40px;
    }

    .amenity-zigzag-icon {
        width: 56px;
        height: 56px;
        display: flex;
        align-items: center;
        justify-content: center;
        border: 1px solid #a9825c;
        border-radius: 50%;
        color: #a9825c;
        font-size: 22px;
        margin-bottom: 20px;
    }

    .amenity-badge-tag {
        display: inline-block;
        background: #f0e6d4;
        color: #6b5a3e;
        padding: 5px 14px;
        border-radius: 30px;
        font-size: 11px;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.04em;
        margin-bottom: 14px;
    }

    .amenity-zigzag-content h3 {
        font-family: 'Playfair Display', serif;
        color: #2b2621;
        font-size: 28px;
        margin-bottom: 14px;
    }

    .amenity-zigzag-content p {
        color: #8a7f6f;
        font-size: 16px;
        line-height: 1.8;
    }

    @media (max-width: 991.98px) {
        .amenity-zigzag-content {
            padding: 25px 15px;
        }

        .amenity-zigzag-image img {
            height: 260px;
        }
    }

</style>

<!-- Hero -->
<section class="amenities-hero">

    <div class="container text-center">

        <span class="hero-badge">
            ★★★★★ Luxury Experience
        </span>

        <h1>
            Hotel Amenities
        </h1>

        <p>
            Everything you need for a luxurious, comfortable,
            and memorable stay.
        </p>

    </div>

</section>

<div class="container py-5">

    <div class="text-center mb-5">

        <span class="section-title">
            PREMIUM FACILITIES
        </span>

        <h2 class="section-heading">
            Designed For Your Comfort
        </h2>

        <p class="section-sub">
            Every service is thoughtfully designed to give you a world-class hotel experience.
        </p>

    </div>

    @php
        $amenities = [
            ['wifi', 'Free WiFi', 'Complimentary', 'Stay connected with high-speed complimentary WiFi available throughout the hotel, from your room to every common area.', 'https://images.unsplash.com/photo-1521737604893-d14cc237f11d?w=900'],
            ['swimming-pool', 'Swimming Pool', 'Premium', 'Unwind at our outdoor infinity pool, surrounded by loungers and scenic views. Open through the day for a refreshing escape.', 'https://images.unsplash.com/photo-1571003123894-1f0594d2b5d9?w=900'],
            ['dumbbell', 'Fitness Gym', '24/7', 'Stay on track with modern, fully equipped gym facilities available around the clock for every guest.', 'https://images.unsplash.com/photo-1534438327276-14e5300c3a48?w=900'],
            ['utensils', 'Restaurant', 'Fine Dining', 'Savour multi-cuisine fine dining crafted by our expert chefs, from local delicacies to international favourites.', 'https://images.unsplash.com/photo-1517248135467-4c7edcad34c4?w=900'],
            ['spa', 'Luxury Spa', 'Wellness', 'Rejuvenate your senses with our professional spa treatments, designed to melt away stress and restore balance.', 'https://images.unsplash.com/photo-1544161515-4ab6ce6db874?w=900'],
            ['car', 'Free Parking', 'Secure', 'Enjoy the convenience of secure, complimentary parking available for every guest throughout their stay.', 'https://images.unsplash.com/photo-1506521781263-d8422e82f27a?w=900'],
            ['concierge-bell', 'Room Service', '24/7', 'Order from our curated menu anytime with attentive, round-the-clock in-room dining service.', 'https://images.unsplash.com/photo-1584132967334-10e028bd69f7?w=900'],
            ['cocktail', 'Bar Lounge', 'Premium', 'End your day with handcrafted cocktails and premium drinks in an intimate lounge setting, perfect for relaxed evenings.', 'https://images.unsplash.com/photo-1470337458703-46ad1756a187?w=900'],
        ];
    @endphp

    @foreach($amenities as $index => $item)

        <div class="row align-items-center amenity-zigzag-row {{ $index % 2 == 1 ? 'flex-row-reverse' : '' }}">

            <div class="col-lg-6">
                <div class="amenity-zigzag-image">
                    <img src="{{ $item[4] }}" alt="{{ $item[1] }}" loading="lazy">
                </div>
            </div>

            <div class="col-lg-6">
                <div class="amenity-zigzag-content">

                    <div class="amenity-zigzag-icon">
                        <i class="fas fa-{{ $item[0] }}"></i>
                    </div>

                    <span class="amenity-badge-tag">{{ $item[2] }}</span>

                    <h3>{{ $item[1] }}</h3>

                    <p>{{ $item[3] }}</p>

                </div>
            </div>

        </div>

    @endforeach

</div>

@endsection