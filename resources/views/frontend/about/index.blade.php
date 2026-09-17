@extends('frontend.layouts.app')

@section('title', 'About Us')

@push('after-styles')
<style>

    /* =========================================================
       HOTEL LUXURA — MODERN ABOUT PAGE
    ========================================================= */

    :root {
        --lux-dark: #25211d;
        --lux-brown: #4a4034;
        --lux-brown-light: #6d5d4d;
        --lux-bronze: #a9825c;
        --lux-bronze-light: #c5a57d;
        --lux-cream: #f7f3ec;
        --lux-white: #fffdf9;
        --lux-muted: #81776c;
        --lux-border: #e8e0d4;
    }

    /* =========================================================
       HERO
    ========================================================= */

    .modern-about {
        background: var(--lux-white);
        color: var(--lux-dark);
    }

    .about-hero {
        position: relative;
        min-height: 68vh;
        margin-top: 0;

        display: flex;
        align-items: center;
        justify-content: center;

        overflow: hidden;

        background:
            linear-gradient(
                180deg,
                rgba(25, 21, 18, .32) 0%,
                rgba(25, 21, 18, .72) 100%
            ),
            url('{{ asset("frontend/images/images (17).jfif") }}')
            center center / cover no-repeat;
    }

    .about-hero::before {
        content: "";
        position: absolute;
        inset: 0;

        background:
            linear-gradient(
                90deg,
                rgba(20, 17, 14, .25),
                transparent 50%,
                rgba(20, 17, 14, .18)
            );
    }

    .about-hero-content {
        position: relative;
        z-index: 2;

        max-width: 850px;
        padding: 80px 20px 60px;

        text-align: center;
    }

    .about-hero-badge {
        display: inline-flex;
        align-items: center;
        gap: 12px;

        padding: 9px 21px;

        border: 1px solid rgba(225, 207, 181, .65);

        background: rgba(37, 33, 29, .18);
        backdrop-filter: blur(6px);

        color: #f4e9d9;

        font-size: 10px;
        font-weight: 700;
        letter-spacing: 3px;
        text-transform: uppercase;
    }

    .about-hero-badge::before,
    .about-hero-badge::after {
        content: "✦";
        color: var(--lux-bronze-light);
        font-size: 9px;
    }

    .about-hero h1 {
        margin: 25px 0 18px;

        font-family: 'Playfair Display', Georgia, serif;
        font-size: clamp(3rem, 6vw, 5.3rem);
        font-weight: 600;
        line-height: 1.05;
        letter-spacing: -1px;

        color: #fffdf9;
    }

    .about-hero p {
        max-width: 600px;
        margin: 0 auto;

        color: #e9ded0;
        font-size: 17px;
        line-height: 1.8;
    }

    /* =========================================================
       STORY SECTION
    ========================================================= */

    .about-story {
        padding: 110px 0;
        background: var(--lux-white);
    }

    .about-story-grid {
        display: flex;
        align-items: center;
    }

    .about-story-content {
        padding: 20px 55px 20px 0;
    }

    .about-kicker {
        display: inline-flex;
        align-items: center;
        gap: 12px;

        color: var(--lux-bronze);

        font-size: 11px;
        font-weight: 700;
        letter-spacing: 3px;
        text-transform: uppercase;
    }

    .about-kicker::before {
        content: "";
        width: 30px;
        height: 1px;
        background: var(--lux-bronze);
    }

    .about-story h2 {
        margin: 17px 0 23px;

        font-family: 'Playfair Display', Georgia, serif;
        font-size: clamp(2.2rem, 4vw, 3.4rem);
        font-weight: 600;
        line-height: 1.18;

        color: var(--lux-dark);
    }

    .about-story h2 span {
        color: var(--lux-bronze);
    }

    .about-story p {
        max-width: 570px;
        margin-bottom: 17px;

        color: var(--lux-muted);
        font-size: 15px;
        line-height: 1.95;
    }

    .about-story-signature {
        margin-top: 30px;

        color: var(--lux-brown);
        font-family: 'Playfair Display', Georgia, serif;
        font-size: 19px;
        font-style: italic;
    }

    /* =========================================================
       IMAGE
    ========================================================= */

    .about-story-image-wrap {
        position: relative;
        padding: 0 18px 18px 0;
    }

    .about-story-image-wrap::after {
        content: "";

        position: absolute;
        right: 0;
        bottom: 0;

        width: 78%;
        height: 82%;

        border: 1px solid var(--lux-bronze);

        z-index: 0;
    }

    .about-img {
        position: relative;
        z-index: 1;

        width: 100%;
        height: 510px;

        display: block;

        object-fit: cover;
        border-radius: 2px;

        box-shadow: 0 25px 55px rgba(43, 38, 33, .13);
    }

    .about-image-label {
        position: absolute;
        z-index: 2;

        left: -12px;
        bottom: 42px;

        padding: 15px 22px;

        background: var(--lux-dark);
        color: #f1e5d5;

        font-size: 10px;
        font-weight: 700;
        letter-spacing: 2px;
        text-transform: uppercase;
    }

    /* =========================================================
       AMENITIES
    ========================================================= */

    .about-amenities-section {
        padding: 105px 0;

        background: var(--lux-cream);
    }

    .about-section-heading {
        max-width: 650px;
        margin: 0 auto 55px;
        text-align: center;
    }

    .about-section-heading h2 {
        margin: 15px 0 12px;

        font-family: 'Playfair Display', Georgia, serif;
        font-size: clamp(2rem, 4vw, 3rem);
        font-weight: 600;

        color: var(--lux-dark);
    }

    .about-section-heading p {
        margin: 0;

        color: var(--lux-muted);
        font-size: 15px;
        line-height: 1.8;
    }

    .amenity-card {
        position: relative;

        height: 100%;
        min-height: 245px;

        padding: 38px 27px;

        background: var(--lux-white);

        border: 1px solid var(--lux-border);

        transition:
            transform .35s ease,
            box-shadow .35s ease,
            border-color .35s ease;
    }

    .amenity-card:hover {
        transform: translateY(-8px);

        border-color: var(--lux-bronze);

        box-shadow: 0 22px 45px rgba(43, 38, 33, .10);
    }

    .amenity-card-number {
        position: absolute;
        top: 22px;
        right: 22px;

        color: #cfc4b6;

        font-family: 'Playfair Display', Georgia, serif;
        font-size: 13px;
    }

    .amenity-icon {
        width: 58px;
        height: 58px;

        display: flex;
        align-items: center;
        justify-content: center;

        margin-bottom: 24px;

        border: 1px solid var(--lux-bronze);
        border-radius: 50%;

        color: var(--lux-bronze);
        font-size: 20px;
    }

    .amenity-card h5 {
        margin-bottom: 10px;

        font-family: 'Playfair Display', Georgia, serif;
        font-size: 21px;
        font-weight: 600;

        color: var(--lux-dark);
    }

    .amenity-card p {
        margin: 0;

        color: var(--lux-muted);
        font-size: 13px;
        line-height: 1.8;
    }

    /* =========================================================
       STATS
    ========================================================= */

    .about-stats-section {
        padding: 90px 0;

        background:
            linear-gradient(
                135deg,
                #29241f,
                #3c332b
            );
    }

    .stats-intro {
        margin-bottom: 55px;
        text-align: center;
    }

    .stats-intro span {
        color: var(--lux-bronze-light);

        font-size: 10px;
        font-weight: 700;
        letter-spacing: 3px;
        text-transform: uppercase;
    }

    .stats-intro h2 {
        margin-top: 13px;

        color: #fffdf8;

        font-family: 'Playfair Display', Georgia, serif;
        font-size: 34px;
        font-weight: 600;
    }

    .lux-stat {
        padding: 10px 25px;
        border-right: 1px solid rgba(255,255,255,.13);
    }

    .lux-stat:last-child {
        border-right: none;
    }

    .lux-stat h3 {
        margin: 0;

        color: #f0dfc7;

        font-family: 'Playfair Display', Georgia, serif;
        font-size: 42px;
        font-weight: 500;
    }

    .lux-stat p {
        margin: 8px 0 0;

        color: #bdb0a1;

        font-size: 10px;
        font-weight: 700;
        letter-spacing: 2px;
        text-transform: uppercase;
    }

    /* =========================================================
       CTA
    ========================================================= */

    .about-cta {
        position: relative;

        padding: 115px 20px;

        text-align: center;

        background:
            linear-gradient(
                180deg,
                rgba(37,33,29,.58),
                rgba(37,33,29,.82)
            ),
            url('{{ asset("frontend/images/cta.jpg") }}')
            center / cover no-repeat;
    }

    .about-cta-content {
        max-width: 760px;
        margin: auto;
    }

    .about-cta small {
        display: block;

        margin-bottom: 16px;

        color: var(--lux-bronze-light);

        font-size: 10px;
        font-weight: 700;
        letter-spacing: 3px;
        text-transform: uppercase;
    }

    .about-cta h2 {
        margin-bottom: 18px;

        color: #fffdf9;

        font-family: 'Playfair Display', Georgia, serif;
        font-size: clamp(2.1rem, 4vw, 3.4rem);
        font-weight: 600;
        line-height: 1.2;
    }

    .about-cta p {
        margin-bottom: 30px;

        color: #e4d8ca;
        font-size: 15px;
    }

    .btn-luxury {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 10px;

        padding: 14px 30px;

        border: 1px solid var(--lux-bronze-light);

        background: var(--lux-bronze);
        color: #fff;

        font-size: 11px;
        font-weight: 700;
        letter-spacing: 1.8px;
        text-transform: uppercase;
        text-decoration: none;

        transition: .3s ease;
    }

    .btn-luxury:hover {
        background: #8f6c49;
        border-color: #8f6c49;
        color: #fff;
        text-decoration: none;
        transform: translateY(-2px);
    }

    / /* =========================================================
    MODERN LUXURY CONTACT SECTION
 ========================================================= */

.lux-contact-section {
    position: relative;

    padding: 85px 0 65px;

    background: #f4efe7;

    overflow: hidden;
}


/* subtle background detail */
.lux-contact-section::before {
    content: "";

    position: absolute;

    width: 420px;
    height: 420px;

    top: -250px;
    right: -180px;

    border: 1px solid rgba(169, 130, 92, .15);
    border-radius: 50%;
}

.lux-contact-section::after {
    content: "";

    position: absolute;

    width: 300px;
    height: 300px;

    bottom: -200px;
    left: -150px;

    border: 1px solid rgba(169, 130, 92, .12);
    border-radius: 50%;
}


/* =========================================================
   HEADER
 ========================================================= */

.lux-contact-header {
    position: relative;
    z-index: 2;

    max-width: 650px;

    margin: 0 auto 55px;

    text-align: center;
}

.lux-contact-kicker {
    display: inline-flex;
    align-items: center;
    gap: 12px;

    color: #a9825c;

    font-size: 10px;
    font-weight: 700;

    letter-spacing: 3px;
    text-transform: uppercase;
}

.lux-contact-kicker::before,
.lux-contact-kicker::after {
    content: "";

    width: 28px;
    height: 1px;

    background: #a9825c;
}

.lux-contact-header h2 {
    margin: 15px 0 12px;

    color: #29241f;

    font-family: 'Playfair Display', Georgia, serif;

    font-size: clamp(2.1rem, 4vw, 3.1rem);

    font-weight: 600;

    line-height: 1.2;
}

.lux-contact-header p {
    max-width: 570px;

    margin: auto;

    color: #81776c;

    font-size: 14px;

    line-height: 1.8;
}


/* =========================================================
   CONTACT GRID
 ========================================================= */

.lux-contact-grid {
    position: relative;
    z-index: 2;

    display: grid;

    grid-template-columns: repeat(3, 1fr);

    background: #fffdf9;

    border: 1px solid #e2d8ca;

    box-shadow: 0 20px 45px rgba(43, 38, 33, .07);
}


/* =========================================================
   CONTACT ITEM
 ========================================================= */

.lux-contact-item {
    display: flex;
    align-items: center;

    min-height: 150px;

    padding: 30px 38px;

    border-right: 1px solid #e7ded2;

    transition: background .3s ease;
}

.lux-contact-item:last-child {
    border-right: none;
}

.lux-contact-item:hover {
    background: #faf6f0;
}


/* =========================================================
   ICON
 ========================================================= */

.lux-contact-icon {
    flex: 0 0 auto;

    width: 52px;
    height: 52px;

    display: flex;
    align-items: center;
    justify-content: center;

    margin-right: 20px;

    border: 1px solid #b8966e;

    border-radius: 50%;

    color: #a9825c;

    font-size: 17px;
}


/* =========================================================
   TEXT
 ========================================================= */

.lux-contact-info span {
    display: block;

    margin-bottom: 5px;

    color: #a9825c;

    font-size: 9px;
    font-weight: 700;

    letter-spacing: 2px;

    text-transform: uppercase;
}

.lux-contact-info h4 {
    margin: 0;

    color: #2b2621;

    font-family: 'Playfair Display', Georgia, serif;

    font-size: 17px;

    font-weight: 600;

    line-height: 1.4;
}

.lux-contact-info small {
    display: block;

    margin-top: 5px;

    color: #9a8e81;

    font-size: 11px;
}


/* =========================================================
   BOTTOM BRAND LINE
 ========================================================= */

.lux-contact-bottom {
    position: relative;
    z-index: 2;

    display: flex;
    align-items: center;
    justify-content: center;

    gap: 20px;

    margin-top: 48px;
}

.lux-contact-bottom span {
    color: #a9825c;

    font-family: 'Playfair Display', Georgia, serif;

    font-size: 11px;

    font-weight: 600;

    letter-spacing: 4px;
}

.lux-contact-line {
    width: 70px;
    height: 1px;

    background: #cdbca7;
}


/* =========================================================
   RESPONSIVE
 ========================================================= */

@media (max-width: 991.98px) {

    .lux-contact-grid {
        grid-template-columns: 1fr;
    }

    .lux-contact-item {
        border-right: none;
        border-bottom: 1px solid #e7ded2;
    }

    .lux-contact-item:last-child {
        border-bottom: none;
    }

}


@media (max-width: 767.98px) {

    .lux-contact-section {
        padding: 65px 0 50px;
    }

    .lux-contact-header {
        margin-bottom: 35px;
    }

    .lux-contact-item {
        min-height: auto;
        padding: 25px 22px;
    }

    .lux-contact-icon {
        width: 46px;
        height: 46px;

        margin-right: 16px;
    }

    .lux-contact-info h4 {
        font-size: 15px;
    }

    .lux-contact-bottom {
        margin-top: 35px;
    }

    .lux-contact-line {
        width: 35px;
    }

}

    /* =========================================================
       RESPONSIVE
    ========================================================= */

    @media (max-width: 991.98px) {

        .about-story {
            padding: 80px 0;
        }

        .about-story-content {
            padding: 10px 20px 45px 0;
        }

        .about-img {
            height: 430px;
        }

        .lux-stat {
            margin-bottom: 35px;
            border-right: none;
        }
    }

    @media (max-width: 767.98px) {

        .about-hero {
            min-height: 52vh;
        }

        .about-hero-content {
            padding: 70px 18px 45px;
        }

        .about-hero h1 {
            font-size: 2.8rem;
        }

        .about-hero p {
            font-size: 14px;
        }

        .about-story,
        .about-amenities-section,
        .about-stats-section,
        .contact-inquiry {
            padding: 70px 0;
        }

        .about-story-content {
            padding: 0 5px 40px;
        }

        .about-story-image-wrap {
            padding-right: 10px;
            padding-bottom: 10px;
        }

        .about-img {
            height: 330px;
        }

        .about-image-label {
            left: 0;
            bottom: 25px;
        }

        .about-section-heading,
        .contact-heading {
            margin-bottom: 38px;
        }

        .amenity-card {
            min-height: 220px;
        }

        .about-cta {
            padding: 80px 20px;
        }

        .lux-stat h3 {
            font-size: 36px;
        }
    }

</style>
@endpush


@section('content')

<div class="modern-about">

    {{-- =====================================================
         HERO
    ====================================================== --}}

    <section class="about-hero">

        <div class="about-hero-content">

            <span class="about-hero-badge">
                Luxury Hotel
            </span>

            <h1>
                About Hotel Luxura
            </h1>

            <p>
                Discover elegance, comfort and unforgettable hospitality,
                thoughtfully created for every stay.
            </p>

        </div>

    </section>


    {{-- =====================================================
         STORY
    ====================================================== --}}

    <section class="about-story">

        <div class="container">

            <div class="row align-items-center about-story-grid">

                <div class="col-lg-6">

                    <div class="about-story-content">

                        <span class="about-kicker">
                            Our Story
                        </span>

                        <h2>
                            Where <span>Luxury</span> Meets
                            Genuine Hospitality
                        </h2>

                        <p>
                            Hotel Luxura provides premium accommodation with
                            world-class facilities, luxurious rooms, delicious
                            dining, wellness experiences and exceptional
                            customer service.
                        </p>

                        <p>
                            Whether you're traveling for business or leisure,
                            our goal is to make every stay memorable, blending
                            timeless elegance with modern comfort.
                        </p>

                        <div class="about-story-signature">
                            Your comfort. Our commitment.
                        </div>

                    </div>

                </div>


                <div class="col-lg-6">

                    <div class="about-story-image-wrap">

                        <img
                            src="{{ asset('frontend/images/hotel.jpg.jfif') }}"
                            class="about-img"
                            alt="Hotel Luxura"
                        >

                        <div class="about-image-label">
                            Hotel Luxura
                        </div>

                    </div>

                </div>

            </div>

        </div>

    </section>


    {{-- =====================================================
         AMENITIES
    ====================================================== --}}

    <section class="about-amenities-section">

        <div class="container">

            <div class="about-section-heading">

                <span class="about-kicker">
                    Why Choose Us
                </span>

                <h2>
                    Everything You Need For A Perfect Stay
                </h2>

                <p>
                    Thoughtfully selected facilities designed to make
                    your stay comfortable, effortless and memorable.
                </p>

            </div>


            <div class="row">

                {{-- 01 --}}
                <div class="col-lg-3 col-md-6 mb-4">

                    <div class="amenity-card">

                        <span class="amenity-card-number">
                            01
                        </span>

                        <div class="amenity-icon">
                            <i class="fas fa-bed"></i>
                        </div>

                        <h5>
                            Luxury Rooms
                        </h5>

                        <p>
                            Elegant rooms with premium comfort,
                            thoughtful details and modern facilities.
                        </p>

                    </div>

                </div>


                {{-- 02 --}}
                <div class="col-lg-3 col-md-6 mb-4">

                    <div class="amenity-card">

                        <span class="amenity-card-number">
                            02
                        </span>

                        <div class="amenity-icon">
                            <i class="fas fa-wifi"></i>
                        </div>

                        <h5>
                            Free WiFi
                        </h5>

                        <p>
                            Stay connected with reliable high-speed
                            internet throughout the hotel.
                        </p>

                    </div>

                </div>


                {{-- 03 --}}
                <div class="col-lg-3 col-md-6 mb-4">

                    <div class="amenity-card">

                        <span class="amenity-card-number">
                            03
                        </span>

                        <div class="amenity-icon">
                            <i class="fas fa-utensils"></i>
                        </div>

                        <h5>
                            Restaurant
                        </h5>

                        <p>
                            Enjoy fine dining and carefully prepared
                            cuisine in an elegant setting.
                        </p>

                    </div>

                </div>


                {{-- 04 --}}
                <div class="col-lg-3 col-md-6 mb-4">

                    <div class="amenity-card">

                        <span class="amenity-card-number">
                            04
                        </span>

                        <div class="amenity-icon">
                            <i class="fas fa-spa"></i>
                        </div>

                        <h5>
                            Spa & Wellness
                        </h5>

                        <p>
                            Relax, refresh and restore yourself with
                            calming wellness experiences.
                        </p>

                    </div>

                </div>

            </div>

        </div>

    </section>


    {{-- =====================================================
         STATS
    ====================================================== --}}

    <section class="about-stats-section">

        <div class="container">

            <div class="stats-intro">

                <span>
                    The Luxura Experience
                </span>

                <h2>
                    Hospitality With A Difference
                </h2>

            </div>


            <div class="row text-center">

                <div class="col-md-3">

                    <div class="lux-stat">

                        <h3>500+</h3>

                        <p>
                            Luxury Rooms
                        </p>

                    </div>

                </div>


                <div class="col-md-3">

                    <div class="lux-stat">

                        <h3>50K+</h3>

                        <p>
                            Happy Guests
                        </p>

                    </div>

                </div>


                <div class="col-md-3">

                    <div class="lux-stat">

                        <h3>15+</h3>

                        <p>
                            Years Experience
                        </p>

                    </div>

                </div>


                <div class="col-md-3">

                    <div class="lux-stat">

                        <h3>24/7</h3>

                        <p>
                            Customer Support
                        </p>

                    </div>

                </div>

            </div>

        </div>

    </section>


    {{-- =====================================================
         CTA
    ====================================================== --}}

    <section class="about-cta">

        <div class="about-cta-content">

            <small>
                Your Stay Awaits
            </small>

            <h2>
                Experience Luxury Like Never Before
            </h2>

            <p>
                Discover refined rooms, thoughtful amenities and
                unforgettable hospitality at Hotel Luxura.
            </p>

            <a
                href="{{ route('frontend.room.index') }}"
                class="btn-luxury"
            >
                Explore Rooms
                <i class="fas fa-arrow-right"></i>
            </a>

        </div>

    </section>


    {{-- =====================================================
         CONTACT
    ====================================================== --}}

  {{-- =====================================================
     CONTACT / GET IN TOUCH
====================================================== --}}

<section class="lux-contact-section">

    <div class="container">

        <div class="lux-contact-header">

            <span class="lux-contact-kicker">
                Get In Touch
            </span>

            <h2>
                We're Here For You
            </h2>

            <p>
                Whether you're planning your stay or simply have a question,
                our team is ready to assist you.
            </p>

        </div>


        <div class="lux-contact-grid">

            {{-- PHONE --}}
            <div class="lux-contact-item">

                <div class="lux-contact-icon">
                    <i class="fas fa-phone"></i>
                </div>

                <div class="lux-contact-info">

                    <span>
                        Call Us
                    </span>

                    <h4>
                        +91 9316449257
                    </h4>

                    <small>
                        Available 24/7
                    </small>

                </div>

            </div>


            {{-- EMAIL --}}
            <div class="lux-contact-item">

                <div class="lux-contact-icon">
                    <i class="fas fa-envelope"></i>
                </div>

                <div class="lux-contact-info">

                    <span>
                        Email Us
                    </span>

                    <h4>
                        admin@hotelmanagement.com
                    </h4>

                    <small>
                        We'll respond shortly
                    </small>

                </div>

            </div>


            {{-- ADDRESS --}}
            <div class="lux-contact-item">

                <div class="lux-contact-icon">
                    <i class="fas fa-map-marker-alt"></i>
                </div>

                <div class="lux-contact-info">

                    <span>
                        Visit Us
                    </span>

                    <h4>
                        Palanpur, Gujarat
                    </h4>

                    <small>
                        India
                    </small>

                </div>

            </div>

        </div>


        <div class="lux-contact-bottom">

            <div class="lux-contact-line"></div>

            <span>
                HOTEL LUXURA
            </span>

            <div class="lux-contact-line"></div>

        </div>

    </div>

</section>

</div>

@endsection