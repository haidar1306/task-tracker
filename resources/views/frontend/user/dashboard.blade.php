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
    url('{{ asset("frontend/images/images (13).jfif") }}');
                    

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

.image-amenity-card {
    overflow: hidden;
    padding: 0;
    border-radius: 16px;
    background: #fff;
    box-shadow: 0 12px 30px rgba(31, 41, 55, .10);
    transition: transform .25s ease, box-shadow .25s ease;
}

.image-amenity-card:hover {
    transform: translateY(-6px);
    box-shadow: 0 18px 38px rgba(31, 41, 55, .16);
}

.image-amenity-media {
    position: relative;
    height: 170px;
    overflow: hidden;
    background: #e9eef0;
}

.image-amenity-media img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    transition: transform .35s ease;
}

.image-amenity-card:hover .image-amenity-media img {
    transform: scale(1.05);
}

.image-amenity-icon {
    position: absolute;
    left: 18px;
    bottom: 16px;
    width: 46px;
    height: 46px;
    display: flex;
    align-items: center;
    justify-content: center;
    border-radius: 50%;
    background: #fff;
    color: #c8a96a;
    font-size: 19px;
    box-shadow: 0 8px 18px rgba(0, 0, 0, .16);
}

.image-amenity-body {
    min-height: 154px;
    padding: 18px 18px 20px;
    text-align: center;
}

.image-amenity-badge {
    display: inline-block;
    margin-bottom: 10px;
    padding: 6px 14px;
    border-radius: 4px;
    background: #c8a96a;
    color: #fff;
    font-size: 11px;
    font-weight: 700;
}

.image-amenity-body h5 {
    margin: 0 0 8px;
    color: #1f2937;
    font-size: 19px;
    font-weight: 700;
}

.image-amenity-body p {
    margin: 0;
    color: #777;
    line-height: 1.55;
}

@media (max-width: 767.98px) {
    .image-amenity-media {
        height: 145px;
    }

    .image-amenity-body {
        min-height: 142px;
        padding: 15px 12px 17px;
    }

    .image-amenity-body h5 {
        font-size: 16px;
    }
}

    </style>
   <section class="hero-section">

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

        </div>

        <div class="booking-search">

            <form action="{{ route('frontend.room.index') }}" method="GET" class="row align-items-end g-3">

                <div class="col-md-3">
                    <label>Check In</label>
                    <input type="date" name="check_in" class="form-control" min="{{ date('Y-m-d') }}">
                </div>

                <div class="col-md-3">
                    <label>Check Out</label>
                    <input type="date" name="check_out" class="form-control" min="{{ date('Y-m-d') }}">
                </div>

                <div class="col-md-3">
                    <label>Guests</label>
                    <select name="guests" class="form-control">
                        <option value="1">1 Guest</option>
                        <option value="2">2 Guests</option>
                        <option value="3">3 Guests</option>
                        <option value="4">4+ Guests</option>
                    </select>
                </div>

                <div class="col-md-3">
                    <button type="submit" class="btn btn-gold w-100">
                        <i class="fas fa-search"></i>
                        Search Rooms
                    </button>
                </div>

            </form>

        </div>

    </div>

</section>
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

            <div class="col-lg-4 col-md-6">
                <div class="luxury-room-card">
                    <div class="room-image">
                        <img src="https://images.unsplash.com/photo-1611892440504-42a792e24d32?w=800">
                        <span class="room-badge">Popular</span>
                    </div>
                    <div class="room-content">
                        <div class="room-rating">★★★★★</div>
                        <h3>Deluxe Room</h3>
                        <p>Elegant room with king size bed, city view, WiFi, AC and a complimentary breakfast every morning.</p>
                        <div class="room-footer">
                            <h4>₹3,500 <small>/ Night</small></h4>
                            <a href="{{ route('frontend.room.index') }}" class="room-btn">View Details</a>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-4 col-md-6">
                <div class="luxury-room-card">
                    <div class="room-image">
                        <img src="https://images.unsplash.com/photo-1590490360182-c33d57733427?w=800">
                        <span class="room-badge">Business Choice</span>
                    </div>
                    <div class="room-content">
                        <div class="room-rating">★★★★★</div>
                        <h3>Executive Room</h3>
                        <p>Premium business room with a private balcony, work desk, modern interiors and lounge access.</p>
                        <div class="room-footer">
                            <h4>₹4,800 <small>/ Night</small></h4>
                            <a href="{{ route('frontend.room.index') }}" class="room-btn">View Details</a>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-4 col-md-6">
                <div class="luxury-room-card">
                    <div class="room-image">
                        <img src="https://images.unsplash.com/photo-1591088398332-8a7791972843?w=800">
                        <span class="room-badge">Luxury</span>
                    </div>
                    <div class="room-content">
                        <div class="room-rating">★★★★★</div>
                        <h3>Royal Suite</h3>
                        <p>Ultimate luxury suite featuring a private jacuzzi, spacious lounge and panoramic city views.</p>
                        <div class="room-footer">
                            <h4>₹7,500 <small>/ Night</small></h4>
                            <a href="{{ route('frontend.room.index') }}" class="room-btn">View Details</a>
                        </div>
                    </div>
                </div>
            </div>

        </div>

    </div>

</section>

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

        @php
            $zigzagAmenities = [
                [
                    'icon' => 'swimming-pool',
                    'title' => 'Swimming Pool',
                    'text' => 'Unwind at our outdoor infinity pool, surrounded by loungers and scenic views. Open through the day for a refreshing escape.',
                    'image' => 'https://images.unsplash.com/photo-1571003123894-1f0594d2b5d9?w=900',
                ],
                [
                    'icon' => 'utensils',
                    'title' => 'Restaurant',
                    'text' => 'Savour multi-cuisine fine dining crafted by our expert chefs, from local delicacies to international favourites, served all day.',
                    'image' => 'https://images.unsplash.com/photo-1517248135467-4c7edcad34c4?w=900',
                ],
                [
                    'icon' => 'spa',
                    'title' => 'Spa & Wellness',
                    'text' => 'Rejuvenate your senses with our luxury spa treatments, designed to melt away stress and restore complete balance.',
                    'image' => 'https://images.unsplash.com/photo-1544161515-4ab6ce6db874?w=900',
                ],
                [
                    'icon' => 'cocktail',
                    'title' => 'Bar Lounge',
                    'text' => 'End your day with handcrafted cocktails and premium drinks in an intimate lounge setting, perfect for relaxed evenings.',
                    'image' => 'https://images.unsplash.com/photo-1470337458703-46ad1756a187?w=900',
                ],
            ];
        @endphp

        @foreach ($zigzagAmenities as $index => $item)
            <div class="row align-items-center amenity-zigzag-row {{ $index % 2 == 1 ? 'flex-row-reverse' : '' }} mb-5">

                <div class="col-lg-6">
                    <div class="amenity-zigzag-image">
                        <img src="{{ $item['image'] }}" alt="{{ $item['title'] }}">
                    </div>
                </div>

                <div class="col-lg-6">
                    <div class="amenity-zigzag-content">
                        <div class="amenity-zigzag-icon">
                            <i class="fas fa-{{ $item['icon'] }}"></i>
                        </div>
                        <h3>{{ $item['title'] }}</h3>
                        <p>{{ $item['text'] }}</p>
                    </div>
                </div>

            </div>
        @endforeach

        <div class="text-center mt-4">
            <a href="{{ route('frontend.amenities.index') }}" class="btn btn-gold">
                View All Amenities
            </a>
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

    <style>
        .dashboard-contact-section {
            margin: 0 auto;
            padding: 78px 0 82px;
            background: #eef4f2;
        }

        .dashboard-contact-heading {
            max-width: 620px;
            margin: 0 auto 34px;
            text-align: center;
        }

        .dashboard-contact-kicker {
            display: inline-block;
            margin-bottom: 10px;
            color: #b18a43;
            font-size: 12px;
            font-weight: 700;
            letter-spacing: .18em;
            text-transform: uppercase;
        }

        .dashboard-contact-heading h2 {
            margin-bottom: 10px;
            color: #111827;
            font-size: clamp(2rem, 4vw, 3rem);
            font-weight: 700;
        }

        .dashboard-contact-heading p {
            margin: 0;
            color: #64748b;
        }

        .dashboard-contact-card {
            height: 100%;
            padding: 30px 24px;
            border: 1px solid rgba(15, 23, 42, .06);
            border-radius: 18px;
            background: #fff;
            text-align: center;
            box-shadow: 0 16px 32px rgba(15, 23, 42, .08);
            transition: transform .25s ease, box-shadow .25s ease;
        }

        .dashboard-contact-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 22px 42px rgba(15, 23, 42, .13);
        }

        .dashboard-contact-icon {
            display: grid;
            width: 58px;
            height: 58px;
            margin: 0 auto 18px;
            place-items: center;
            border-radius: 50%;
            background: #fff7e5;
            color: #c8a96a;
            font-size: 22px;
        }

        .dashboard-contact-card h4 {
            margin-bottom: 8px;
            color: #111827;
            font-size: 20px;
            font-weight: 700;
        }

        .dashboard-contact-card p,
        .dashboard-contact-card a {
            margin: 0;
            color: #64748b;
            font-size: 15px;
            line-height: 1.6;
            text-decoration: none;
        }

        .dashboard-contact-card a:hover {
            color: #b18a43;
        }

        @media (max-width: 767.98px) {
            .dashboard-contact-section {
                padding: 56px 0 62px;
            }
        }
    </style>

    <section class="dashboard-contact-section">

        <div class="dashboard-contact-heading">
            <span class="dashboard-contact-kicker">Guest Support</span>
            <h2>Need Any Help?</h2>
            <p>Our team is ready to help make your stay comfortable and effortless.</p>
        </div>

        <div class="container">
            <div class="row">

                <div class="col-lg-4 mb-4">

                    <div class="dashboard-contact-card">

                        <div class="dashboard-contact-icon">
                            <i class="fas fa-phone"></i>
                        </div>

                        <h4>Call Us</h4>

                        <a href="tel:+919316449257">+91 9316449257</a>

                    </div>

                </div>

                <div class="col-lg-4 mb-4">

                    <div class="dashboard-contact-card">

                        <div class="dashboard-contact-icon">
                            <i class="fas fa-envelope"></i>
                        </div>

                        <h4>Email</h4>

                        <a href="mailto:haidarmaknojiya1306@gmail.com">haidarmaknojiya1306@gmail.com</a>

                    </div>

                </div>

                <div class="col-lg-4 mb-4">

                    <div class="dashboard-contact-card">

                        <div class="dashboard-contact-icon">
                            <i class="fas fa-map-marker-alt"></i>
                        </div>

                        <h4>Address</h4>

                        <p>Palanpur, Gujarat, India</p>

                    </div>

                </div>

            </div>
        </div>

    </section>


    <!-- ==========================================
                                                                                            Footer
                                                                                            ========================================== -->
<!-- 
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

    </footer> -->
    
   

@endsection

