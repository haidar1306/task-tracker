@extends('frontend.layouts.app')
<!-- public\css\frontend\user-dashboard.css -->
@push('after-styles')
    <link rel="stylesheet" href="{{ asset('css/frontend/user-dashboard.css') }}">
@endpush

@section('title', 'Dashboard')



@section('content')
<style>
    
.hero-section{
    position:relative;
    min-height:100vh;

    background-image:
        linear-gradient(
            180deg,
            rgba(7,15,26,.55) 0%,
            rgba(7,15,26,.35) 45%,
            rgba(7,15,26,.80) 100%
        ),
    url('{{ asset("frontend/images/images (4).jfif") }}');
                    

    background-size:cover;
    background-position:center;
    background-repeat:no-repeat;
    background-color:#0c2338;

    display:flex;
    align-items:center;
    justify-content:center;

    padding-top:120px;
    text-align:center;

    overflow:hidden;
}

    </style>

    <!-- ===========================
                                                                                            Hero Section
                                                                                            =========================== -->

    <section class="hero-section">

      
       @include('frontend.layouts.navbar')

        <div class="container">


            <div class="hero-content text-center">

                <span class="hero-subtitle">
                    LUXURY HOTEL EXPERIENCE
                </span>

                <h1>
                    Enjoy A Luxury <br>
                    Experience
                </h1>

                <p>
                    Experience premium hospitality, luxury rooms and unforgettable memories.
                    Book your perfect stay with comfort, elegance and world-class service.
                </p>

                <div class="mt-5">
                    <a href="{{ route('frontend.room.index') }}" class="btn btn-gold mr-3">
                        <i class="fas fa-bed"></i>
                        Book Room
                    </a>

                    <a href="{{ route('frontend.reservation.index') }}" class="btn btn-white">
                        <i class="fas fa-calendar-check"></i>
                        My Reservations
                    </a>
                </div>

            </div>

        </div>

    </section>
    <!-- ===========================
                                                                                            Featured Rooms
                                                                                            =========================== -->

    <section class="featured-room-section">

        <div class="container">


            <div class="text-center mb-5">

                <span class="section-subtitle">
                    OUR ACCOMMODATION
                </span>

                <h2 class="section-title">
                    Featured Rooms
                </h2>

                <p class="section-description">
                    Experience luxury and comfort with our premium rooms designed for unforgettable stays.
                </p>

            </div>



            <div class="row g-4">


                <!-- Deluxe Room -->

                <div class="col-lg-4 col-md-6">

                    <div class="luxury-room-card">


                        <div class="room-image">

                            <img src="https://images.unsplash.com/photo-1566665797739-1674de7a421a?w=800">

                            <span class="room-badge">
                                Popular
                            </span>

                        </div>



                        <div class="room-content">


                            <div class="room-rating">
                                ★★★★★
                            </div>


                            <h3>
                                Deluxe Room
                            </h3>


                            <p>
                                Elegant room with king size bed,
                                WiFi, AC and complimentary breakfast.
                            </p>


                            <div class="room-footer">

                                <h4>
                                    ₹3,500
                                    <small>/ Night</small>
                                </h4>


                                <a href="#" class="room-btn">
                                    Book Now
                                </a>

                            </div>


                        </div>


                    </div>

                </div>




                <!-- Executive Room -->


                <div class="col-lg-4 col-md-6">


                    <div class="luxury-room-card">


                        <div class="room-image">

                            <img src="https://images.unsplash.com/photo-1582719478250-c89cae4dc85b?w=800">


                            <span class="room-badge">
                                Business Choice
                            </span>


                        </div>



                        <div class="room-content">


                            <div class="room-rating">
                                ★★★★★
                            </div>


                            <h3>
                                Executive Room
                            </h3>


                            <p>
                                Premium business room with luxury facilities,
                                balcony and modern interiors.
                            </p>


                            <div class="room-footer">


                                <h4>
                                    ₹4,800
                                    <small>/ Night</small>
                                </h4>


                                <a href="#" class="room-btn">
                                    Book Now
                                </a>


                            </div>


                        </div>


                    </div>


                </div>





                <!-- Royal Suite -->


                <div class="col-lg-4 col-md-6">


                    <div class="luxury-room-card">


                        <div class="room-image">


                            <img src="https://images.unsplash.com/photo-1578683010236-d716f9a3f461?w=800">


                            <span class="room-badge">
                                Luxury
                            </span>


                        </div>



                        <div class="room-content">


                            <div class="room-rating">
                                ★★★★★
                            </div>


                            <h3>
                                Royal Suite
                            </h3>


                            <p>
                                Ultimate luxury suite with jacuzzi,
                                lounge and beautiful city view.
                            </p>



                            <div class="room-footer">


                                <h4>
                                    ₹7,500
                                    <small>/ Night</small>
                                </h4>


                                <a href="#" class="room-btn">
                                    Book Now
                                </a>


                            </div>



                        </div>


                    </div>


                </div>



            </div>


        </div>

    </section>

    <!-- ===========================
                                                                                            Amenities
                                                                                            =========================== -->

    <section class="amenities-section">

        <div class="container">


            <div class="text-center mb-5">

                <span class="section-subtitle">
                    HOTEL FACILITIES
                </span>

                <h2 class="section-title">
                    Hotel Amenities
                </h2>

                <p class="section-description">
                    Enjoy world-class facilities designed to make your stay comfortable and memorable.
                </p>

            </div>



            <div class="row gx-4 gy-4">

                <div class="col-lg-3 col-md-4 col-6 mb-4">

                    <div class="luxury-amenity-card">

                        <div class="amenity-icon">
                            <i class="fas fa-wifi"></i>
                        </div>

                        <h5>Free WiFi</h5>

                        <p>
                            High Speed Internet
                        </p>

                    </div>

                </div>



                <div class="col-lg-3 col-md-4 col-6 mb-4">

                    <div class="luxury-amenity-card">

                        <div class="amenity-icon">
                            <i class="fas fa-swimming-pool"></i>
                        </div>

                        <h5>Swimming Pool</h5>

                        <p>
                            Outdoor Pool
                        </p>

                    </div>

                </div>




                <div class="col-lg-3 col-md-4 col-6 mb-4">

                    <div class="luxury-amenity-card">

                        <div class="amenity-icon">
                            <i class="fas fa-dumbbell"></i>
                        </div>

                        <h5>Fitness Gym</h5>

                        <p>
                            Modern Equipment
                        </p>

                    </div>

                </div>




                <div class="col-lg-3 col-md-4 col-6 mb-4">

                    <div class="luxury-amenity-card">

                        <div class="amenity-icon">
                            <i class="fas fa-utensils"></i>
                        </div>

                        <h5>Restaurant</h5>

                        <p>
                            Multi Cuisine
                        </p>

                    </div>

                </div>




                <div class="col-lg-3 col-md-4 col-6 mb-4">

                    <div class="luxury-amenity-card">

                        <div class="amenity-icon">
                            <i class="fas fa-spa"></i>
                        </div>

                        <h5>Spa & Wellness</h5>

                        <p>
                            Luxury Relaxation
                        </p>

                    </div>

                </div>




                <div class="col-lg-3 col-md-4 col-6 mb-4">

                    <div class="luxury-amenity-card">

                        <div class="amenity-icon">
                            <i class="fas fa-car"></i>
                        </div>

                        <h5>Parking</h5>

                        <p>
                            Secure Parking
                        </p>

                    </div>

                </div>




                <div class="col-lg-3 col-md-4 col-6 mb-4">

                    <div class="luxury-amenity-card">

                        <div class="amenity-icon">
                            <i class="fas fa-concierge-bell"></i>
                        </div>

                        <h5>Room Service</h5>

                        <p>
                            24×7 Available
                        </p>

                    </div>

                </div>




                <div class="col-lg-3 col-md-4 col-6 mb-4">

                    <div class="luxury-amenity-card">

                        <div class="amenity-icon">
                            <i class="fas fa-cocktail"></i>
                        </div>

                        <h5>Bar Lounge</h5>

                        <p>
                            Premium Drinks
                        </p>

                    </div>

                </div>



            </div>


        </div>

    </section>

    <!-- ===========================
                                                                                            Why Choose Us
                                                                                            =========================== -->

    <section class="why-choose-section py-5">

        <div class="container">

            <div class="text-center mb-5">

                <span class="section-subtitle">
                    WHY CHOOSE US
                </span>

                <h2 class="section-title">
                    Experience Hospitality at Its Finest
                </h2>

                <p class="section-description">
                    We combine luxury, comfort, and exceptional service to make every stay unforgettable.
                </p>

            </div>

            <div class="row g-4">

                <div class="col-lg-4 col-md-6">

                    <div class="feature-card">

                        <div class="feature-icon">
                            <i class="fas fa-star"></i>
                        </div>

                        <h4>Luxury Experience</h4>

                        <p>
                            Enjoy elegant rooms, premium amenities, and personalized hospitality designed for a memorable
                            stay.
                        </p>

                    </div>

                </div>

                <div class="col-lg-4 col-md-6">

                    <div class="feature-card">

                        <div class="feature-icon">
                            <i class="fas fa-shield-alt"></i>
                        </div>

                        <h4>Safe & Secure Stay</h4>

                        <p>
                            Your comfort and safety are ensured with 24×7 security, CCTV surveillance, and professional
                            staff.
                        </p>

                    </div>

                </div>

                <div class="col-lg-4 col-md-6">

                    <div class="feature-card">

                        <div class="feature-icon">
                            <i class="fas fa-headset"></i>
                        </div>

                        <h4>24×7 Guest Support</h4>

                        <p>
                            Our dedicated support team is always available to assist you with bookings and hotel services.
                        </p>

                    </div>

                </div>

            </div>

        </div>

    </section>
    <!-- ===================================
                                                                                            SPECIAL OFFER
                                                                                            =================================== -->

    <!-- <section class="offer-section">

        <div class="container">

            <div class="offer-header mb-4">
                <span class="section-kicker">Latest</span>
                <h2 class="section-title text-left">Hotel Offers</h2>
            </div>

            <div class="offers-grid">

                <article class="offer-card">
                    <div class="offer-date">
                        <span class="offer-month">Jul</span>
                        <strong>04</strong>
                    </div>
                    <div class="offer-copy">
                        <span class="offer-badge">Offers</span>
                        <h3>Summer Escape Deal</h3>
                        <p>Enjoy up to 20% off on luxury rooms with complimentary breakfast.</p>
                    </div>
                </article>

                <article class="offer-card is-featured">
                    <div class="offer-date">
                        <span class="offer-month">Aug</span>
                        <strong>16</strong>
                    </div>
                    <div class="offer-copy">
                        <span class="offer-badge">Hotel Updates</span>
                        <h3>Weekend Luxury Stay</h3>
                        <p>Free airport pickup, spa access, and a curated in-room welcome setup.</p>
                    </div>
                </article>

            </div>

        </div>

    </section> -->
    <style>
        .offer-section {
            padding: 60px 0 30px;
        }

        .offer-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 12px;
        }

        .section-kicker {
            display: inline-block;
            font-size: 12px;
            text-transform: uppercase;
            letter-spacing: 0.18em;
            color: #8c6a2d;
            font-weight: 700;
        }

        .offers-grid {
            display: grid;
            grid-template-columns: repeat(2, minmax(0, 1fr));
            gap: 22px;
        }

        .offer-card {
            display: flex;
            align-items: center;
            gap: 18px;
            background: rgba(255, 255, 255, 0.78);
            border: 1px solid rgba(15, 23, 42, 0.08);
            border-radius: 18px;
            padding: 18px 20px;
            box-shadow: 0 18px 40px rgba(15, 23, 42, 0.06);
            transition: transform 0.25s ease, box-shadow 0.25s ease;
        }

        .offer-card:hover {
            transform: translateY(-2px);
            box-shadow: 0 22px 42px rgba(15, 23, 42, 0.10);
        }

        .offer-card.is-featured {
            background: linear-gradient(135deg, rgba(255, 255, 255, 0.88), rgba(242, 245, 249, 0.95));
        }

        .offer-date {
            min-width: 88px;
            height: 96px;
            border-radius: 16px;
            background: linear-gradient(180deg, #0d1b2a 0%, #172a3a 100%);
            color: #fff;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            text-align: center;
            box-shadow: inset 0 0 0 1px rgba(255,255,255,0.08);
        }

        .offer-month {
            font-size: 12px;
            letter-spacing: 0.1em;
            text-transform: uppercase;
            opacity: 0.8;
        }

        .offer-date strong {
            font-size: 28px;
            line-height: 1;
            margin-top: 6px;
            font-weight: 800;
        }

        .offer-copy {
            flex: 1;
        }

        .offer-badge {
            display: inline-block;
            font-size: 11px;
            font-weight: 700;
            color: #8c6a2d;
            background: rgba(212, 175, 55, 0.12);
            border: 1px solid rgba(212, 175, 55, 0.25);
            padding: 5px 9px;
            border-radius: 999px;
            margin-bottom: 8px;
            text-transform: uppercase;
            letter-spacing: 0.08em;
        }

        .offer-copy h3 {
            margin: 0 0 6px;
            font-size: 1.8rem;
            font-weight: 800;
            color: #111827;
        }

        .offer-copy p {
            margin: 0;
            color: #4b5563;
            line-height: 1.6;
            font-size: 0.98rem;
        }

        @media (max-width: 767px) {
            .offers-grid {
                grid-template-columns: 1fr;
            }

            .offer-card {
                padding: 16px;
            }

            .offer-copy h3 {
                font-size: 1.4rem;
            }
        }
    </style>

    <!-- ==========================================
                                                                                            Contact Us
                                                                                            ========================================== -->

    <section class="container py-5">

        <h2 class="section-title">
            Need Any Help?
        </h2>

        <div class="row">

            <div class="col-lg-4 mb-4">

                <div class="contact-card">

                    <i class="fas fa-phone"></i>

                    <h4 class="mt-3">
                        Call Us
                    </h4>

                    <p>
                        +91 9316449257
                    </p>

                </div>

            </div>

            <div class="col-lg-4 mb-4">

                <div class="contact-card">

                    <i class="fas fa-envelope"></i>

                    <h4 class="mt-3">
                        Email
                    </h4>

                    <p>
                        admin@hotelmanagement.com
                    </p>

                </div>

            </div>

            <div class="col-lg-4 mb-4">

                <div class="contact-card">

                    <i class="fas fa-map-marker-alt"></i>

                    <h4 class="mt-3">
                        Address
                    </h4>

                    <p>
                        Palanpur, Gujarat, India
                    </p>

                </div>

            </div>

        </div>

    </section>


    <!-- ==========================================
                                                                                            Footer
                                                                                            ========================================== -->

    <footer class="footer">

        <div class="container">

            <div class="row">

                <div class="col-lg-4">

                    <h4>

                        Luxury Hotel

                    </h4>

                    <p>

                        Experience luxury hospitality,
                        premium rooms and world class service.

                    </p>

                </div>

                <div class="col-lg-4">

                    <h4>

                        Quick Links

                    </h4>

                    <ul class="list-unstyled">

                        <li><a href="#">Home</a></li>

                        <li><a href="#">Rooms</a></li>

                        <li><a href="#">Gallery</a></li>

                        <li><a href="#">Contact</a></li>

                    </ul>

                </div>

                <div class="col-lg-4">

                    <h4>

                        Customer

                    </h4>

                    <ul class="list-unstyled">

                        <li><a href="#">My Bookings</a></li>

                        <li><a href="#">Payments</a></li>

                        <li><a href="{{ route('frontend.user.account') }}">Profile</a></li>

                        <li>

                            <a href="{{ route('frontend.auth.logout') }}">

                                Logout

                            </a>

                        </li>

                    </ul>

                </div>

            </div>

            <div class="footer-bottom">

                <p class="mb-1">

                    © {{ date('Y') }} Luxury Hotel Management System

                </p>

                <small>

                    Designed with ❤️ for Better Hospitality

                </small>

            </div>

        </div>

    </footer>

@endsection