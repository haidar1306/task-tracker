@extends('frontend.layouts.app')

@section('title', 'About Us')

@push('after-styles')
<style>

    /* ===========================
       HERO
    =========================== */

    .about-hero {
        position: relative;
        min-height: 65vh;
        margin-top: -24px;
        background:
            linear-gradient(180deg, rgba(43,38,33,.55) 0%, rgba(43,38,33,.78) 100%),
            url('{{ asset("frontend/images/images (17).jfif") }}') center/cover no-repeat;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .about-hero-badge {
        display: inline-block;
        padding: 10px 26px;
        border: 1px solid #d9c4a5;
        color: #f0e6d4;
        border-radius: 30px;
        letter-spacing: 3px;
        font-size: 12px;
        font-weight: 600;
        text-transform: uppercase;
    }

    .about-hero h1 {
        font-family: 'Playfair Display', serif;
        font-size: clamp(2.5rem, 5vw, 4.2rem);
        font-weight: 700;
        color: #fffdfa;
        margin: 22px 0 14px;
    }

    .about-hero p {
        color: #e8dcc8;
        font-size: 17px;
        max-width: 560px;
        margin: 0 auto;
    }

    /* ===========================
       ABOUT SECTION
    =========================== */

    .about-section {
        padding: 90px 0;
        background: #fffdfa;
    }

    .about-img {
        width: 100%;
        height: 460px;
        object-fit: cover;
        border-radius: 16px;
    }

    .about-kicker {
        color: #a9825c;
        letter-spacing: 3px;
        font-weight: 700;
        font-size: 13px;
        text-transform: uppercase;
    }

    .about-section h2 {
        font-family: 'Playfair Display', serif;
        color: #2b2621;
        font-weight: 700;
        font-size: 38px;
        margin: 16px 0 22px;
    }

    .about-section p {
        color: #8a7f6f;
        line-height: 1.9;
        font-size: 16px;
        margin-bottom: 18px;
    }

    /* ===========================
       AMENITIES HIGHLIGHT
    =========================== */

    .about-amenities-section {
        padding: 90px 0;
        background: #f7f2ea;
    }

    .amenity-card {
        background: #fffdfa;
        border: 1px solid #e5dccb;
        border-radius: 14px;
        padding: 40px 25px;
        text-align: center;
        height: 100%;
        transition: .3s;
    }

    .amenity-card:hover {
        transform: translateY(-8px);
        border-color: #a9825c;
        box-shadow: 0 18px 36px rgba(43, 38, 33, .10);
    }

    .amenity-card i {
        font-size: 34px;
        color: #a9825c;
    }

    .amenity-card h5 {
        font-family: 'Playfair Display', serif;
        color: #2b2621;
        margin: 18px 0 10px;
    }

    .amenity-card p {
        color: #8a7f6f;
        font-size: 14px;
        margin: 0;
    }

    /* ===========================
       STATISTICS
    =========================== */

    .about-stats-section {
        padding: 80px 0;
        background: #2b2621;
    }

    .about-stats-section h2 {
        font-family: 'Playfair Display', serif;
        color: #d9c4a5;
        font-weight: 700;
        font-size: 42px;
    }

    .about-stats-section p {
        color: #c9bfae;
        font-size: 14px;
        letter-spacing: 0.05em;
        text-transform: uppercase;
        margin-top: 6px;
    }

    /* ===========================
       CTA
    =========================== */

    .about-cta {
        padding: 110px 0;
        text-align: center;
        background:
            linear-gradient(180deg, rgba(43,38,33,.6) 0%, rgba(43,38,33,.8) 100%),
            url('{{ asset("frontend/images/cta.jpg") }}') center/cover no-repeat;
    }

    .about-cta h2 {
        font-family: 'Playfair Display', serif;
        color: #fffdfa;
        font-weight: 700;
        font-size: clamp(1.8rem, 4vw, 2.8rem);
        max-width: 720px;
        margin: 0 auto 18px;
        line-height: 1.3;
    }

    .about-cta p {
        color: #e8dcc8;
        margin-bottom: 30px;
    }

    .about-cta .btn-gold {
        display: inline-block;
        padding: 14px 36px;
        background: #a9825c;
        color: #fff;
        border-radius: 8px;
        text-decoration: none;
        font-weight: 600;
        letter-spacing: 0.04em;
        text-transform: uppercase;
        font-size: 14px;
        transition: .3s;
    }

    .about-cta .btn-gold:hover {
        background: #8a6844;
        color: #fff;
    }

    /* ===========================
       CONTACT INQUIRY
    =========================== */

    .contact-inquiry {
        background: #f7f2ea;
        padding: 90px 0;
    }

    .contact-inquiry .about-kicker {
        display: block;
        text-align: center;
    }

    .contact-inquiry h2 {
        font-family: 'Playfair Display', serif;
        color: #2b2621;
        font-weight: 700;
        font-size: 36px;
        text-align: center;
        margin: 12px 0 8px;
    }

    .contact-inquiry > .container > p,
    .contact-inquiry .text-center > p {
        text-align: center;
        color: #8a7f6f;
    }

    .contact-card {
        background: #fffdfa;
        padding: 45px 30px;
        text-align: center;
        border-radius: 16px;
        border: 1px solid #e5dccb;
        transition: .3s;
    }

    .contact-card:hover {
        transform: translateY(-8px);
        box-shadow: 0 18px 36px rgba(43, 38, 33, .10);
    }

    .contact-card i {
        font-size: 32px;
        color: #a9825c;
        margin-bottom: 20px;
        display: inline-block;
    }

    .contact-card h4 {
        font-family: 'Playfair Display', serif;
        color: #2b2621;
        font-size: 22px;
        margin-bottom: 12px;
    }

    .contact-card p {
        color: #8a7f6f;
        font-size: 16px;
        margin: 0;
    }

    @media (max-width: 767.98px) {
        .about-hero {
            min-height: 46vh;
        }

        .about-section,
        .about-amenities-section,
        .about-cta,
        .contact-inquiry {
            padding: 55px 0;
        }

        .about-img {
            height: 300px;
            margin-top: 30px;
        }
    }

</style>
@endpush

@section('content')

    <!-- Hero -->
    <section class="about-hero">
        <div class="container text-center">

            <span class="about-hero-badge">Luxury Hotel</span>

            <h1>About Hotel Luxura</h1>

            <p>Discover elegance, comfort and unforgettable hospitality.</p>

        </div>
    </section>

    <!-- About -->
    <section class="about-section">
        <div class="container">

            <div class="row align-items-center">

                <div class="col-lg-6">

                    <span class="about-kicker">About Hotel</span>

                    <h2>Experience Luxury Like Never Before</h2>

                    <p>
                        Hotel Luxura provides premium accommodation with world-class facilities,
                        luxurious rooms, delicious dining, wellness experiences and exceptional
                        customer service.
                    </p>

                    <p>
                        Whether you're traveling for business or leisure, our goal is to make
                        every stay memorable, blending timeless elegance with modern comfort.
                    </p>

                </div>

                <div class="col-lg-6">
                    <img src="{{ asset('frontend/images/hotel.jpg.jfif') }}" class="about-img">
                </div>

            </div>

        </div>
    </section>

    <!-- Amenities Highlight -->
    <section class="about-amenities-section">

        <div class="container">

            <div class="text-center mb-5">
                <span class="about-kicker">Why Choose Us</span>
                <h2 style="font-family:'Playfair Display', serif; color:#2b2621; font-weight:700; margin-top:12px;">
                    Our Amenities
                </h2>
            </div>

            <div class="row g-4">

                <div class="col-md-3">
                    <div class="amenity-card">
                        <i class="fas fa-bed"></i>
                        <h5>Luxury Rooms</h5>
                        <p>Elegant rooms with premium comfort.</p>
                    </div>
                </div>

                <div class="col-md-3">
                    <div class="amenity-card">
                        <i class="fas fa-wifi"></i>
                        <h5>Free WiFi</h5>
                        <p>Fast internet in every room.</p>
                    </div>
                </div>

                <div class="col-md-3">
                    <div class="amenity-card">
                        <i class="fas fa-utensils"></i>
                        <h5>Restaurant</h5>
                        <p>Fine dining with international cuisine.</p>
                    </div>
                </div>

                <div class="col-md-3">
                    <div class="amenity-card">
                        <i class="fas fa-spa"></i>
                        <h5>Spa & Wellness</h5>
                        <p>Relax and refresh yourself.</p>
                    </div>
                </div>

            </div>

        </div>

    </section>

    <!-- Statistics -->
    <section class="about-stats-section">

        <div class="container">

            <div class="row text-center">

                <div class="col-md-3">
                    <h2>500+</h2>
                    <p>Luxury Rooms</p>
                </div>

                <div class="col-md-3">
                    <h2>50K+</h2>
                    <p>Happy Guests</p>
                </div>

                <div class="col-md-3">
                    <h2>15+</h2>
                    <p>Years Experience</p>
                </div>

                <div class="col-md-3">
                    <h2>24/7</h2>
                    <p>Customer Support</p>
                </div>

            </div>

        </div>

    </section>

    <!-- CTA -->
    <section class="about-cta">

        <div class="container">

            <h2>Experience Luxury Like Never Before — Reserve Your Room Today</h2>

            <p>Book your room today and enjoy unforgettable hospitality.</p>

            <a href="{{ route('frontend.room.index') }}" class="btn-gold">
                Explore Rooms
            </a>

        </div>

    </section>

    <!-- Contact Inquiry -->
    <section class="contact-inquiry">

        <div class="container">

            <div class="text-center mb-5">
                <span class="about-kicker">Get In Touch</span>
                <h2>Need Any Help?</h2>
                <p>Contact us for booking and inquiries</p>
            </div>

            <div class="row g-4">

                <div class="col-md-4">
                    <div class="contact-card">
                        <i class="fas fa-phone"></i>
                        <h4>Call Us</h4>
                        <p>+91 9316449257</p>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="contact-card">
                        <i class="fas fa-envelope"></i>
                        <h4>Email</h4>
                        <p>admin@hotelmanagement.com</p>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="contact-card">
                        <i class="fas fa-map-marker-alt"></i>
                        <h4>Address</h4>
                        <p>Palanpur, Gujarat, India</p>
                    </div>
                </div>

            </div>

        </div>

    </section>

@endsection