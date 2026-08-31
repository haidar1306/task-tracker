@extends('frontend.layouts.app')

@section('content')
    <section class="hotel-page-hero updates-hero">
        <div class="container">
            <div class="hero-inner">
                <span class="section-tag">Latest Updates</span>
                <h1>Hotel Updates</h1>
                <p>Stay in tune with our latest experiences, renovations, seasonal highlights, and guest-first enhancements.</p>
            </div>
        </div>
    </section>

    <section class="updates-wrapper">
        <div class="container">
            <div class="updates-grid">
                <article class="update-card">
                    <div class="update-image accent-one"></div>
                    <div class="update-body">
                        <span class="update-tag">New Experience</span>
                        <h3>Luxury Rooftop Dining</h3>
                        <p>Our rooftop restaurant now serves signature dining experiences with sunset views and curated chef menus.</p>
                    </div>
                </article>

                <article class="update-card">
                    <div class="update-image accent-two"></div>
                    <div class="update-body">
                        <span class="update-tag">Property Upgrade</span>
                        <h3>Refreshed Executive Suites</h3>
                        <p>Discover newly renovated suites with upgraded interiors, enhanced comfort, and contemporary amenities.</p>
                    </div>
                </article>

                <article class="update-card">
                    <div class="update-image accent-three"></div>
                    <div class="update-body">
                        <span class="update-tag">Guest Favorite</span>
                        <h3>Wellness and Spa Access</h3>
                        <p>Enjoy personalized wellness sessions, guided yoga, and exclusive spa access for our premium guests.</p>
                    </div>
                </article>
            </div>
        </div>
    </section>

    <style>
        .updates-hero {
            background: linear-gradient(135deg, rgba(13, 27, 42, 0.96), rgba(19, 42, 59, 0.9));
        }

        .updates-wrapper {
            padding: 60px 0 80px;
            background: #f6f7f9;
        }

        .updates-grid {
            display: grid;
            grid-template-columns: repeat(3, minmax(0, 1fr));
            gap: 26px;
        }

        .update-card {
            background: #fff;
            border-radius: 20px;
            overflow: hidden;
            box-shadow: 0 18px 40px rgba(15, 23, 42, 0.06);
            border: 1px solid rgba(15, 23, 42, 0.06);
        }

        .update-image {
            height: 220px;
            background-size: cover;
            background-position: center;
        }

        .accent-one {
            background: linear-gradient(135deg, rgba(13, 27, 42, 0.25), rgba(17, 95, 128, 0.5)), url('https://images.unsplash.com/photo-1559339352-11d035aa65de?auto=format&fit=crop&w=900&q=80');
        }

        .accent-two {
            background: linear-gradient(135deg, rgba(12, 20, 38, 0.25), rgba(125, 104, 39, 0.5)), url('https://images.unsplash.com/photo-1505693416388-ac5ce068fe85?auto=format&fit=crop&w=900&q=80');
        }

        .accent-three {
            background: linear-gradient(135deg, rgba(12, 20, 38, 0.25), rgba(44, 99, 109, 0.5)), url('https://images.unsplash.com/photo-1540555700478-4be289fbecef?auto=format&fit=crop&w=900&q=80');
        }

        .update-body {
            padding: 20px 20px 24px;
        }

        .update-tag {
            display: inline-block;
            font-size: 11px;
            font-weight: 700;
            letter-spacing: 0.08em;
            text-transform: uppercase;
            color: #8c6a2d;
            background: rgba(212, 175, 55, 0.12);
            border: 1px solid rgba(212, 175, 55, 0.22);
            padding: 6px 10px;
            border-radius: 999px;
            margin-bottom: 12px;
        }

        .update-body h3 {
            margin: 0 0 10px;
            font-size: 2rem;
            font-weight: 800;
            color: #111827;
        }

        .update-body p {
            margin: 0;
            color: #4b5563;
            line-height: 1.7;
        }

        @media (max-width: 991px) {
            .updates-grid {
                grid-template-columns: 1fr 1fr;
            }
        }

        @media (max-width: 767px) {
            .updates-grid {
                grid-template-columns: 1fr;
            }
        }
    </style>
@endsection
