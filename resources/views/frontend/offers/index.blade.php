@extends('frontend.layouts.app')

@section('content')
    <section class="hotel-page-hero">
        <div class="container">
            <div class="hero-inner">
                <span class="section-tag">Exclusive Savings</span>
                <h1>Hotel Offers</h1>
                <p>Enjoy curated stays, seasonal deals, and premium experiences designed for your next unforgettable getaway.</p>
            </div>
        </div>
    </section>

    <section class="offers-wrapper">
        <div class="container">
            <div class="offers-grid">
                <article class="offer-card">
                    <div class="offer-date">
                        <span>Jul</span>
                        <strong>04</strong>
                    </div>
                    <div class="offer-body">
                        <span class="offer-label">Offers</span>
                        <h3>Summer Escape Deal</h3>
                        <p>Get up to 20% off on deluxe rooms with complimentary breakfast, free Wi‑Fi, and late checkout.</p>
                        <a href="{{ route('frontend.contact') }}" class="theme-btn">Book This Offer</a>
                    </div>
                </article>

                <article class="offer-card featured">
                    <div class="offer-date">
                        <span>Aug</span>
                        <strong>16</strong>
                    </div>
                    <div class="offer-body">
                        <span class="offer-label">Featured</span>
                        <h3>Weekend Luxury Stay</h3>
                        <p>Includes free airport pickup, a spa session, and a curated welcome package for two.</p>
                        <a href="{{ route('frontend.contact') }}" class="theme-btn">Reserve Now</a>
                    </div>
                </article>

                <article class="offer-card">
                    <div class="offer-date">
                        <span>Sep</span>
                        <strong>09</strong>
                    </div>
                    <div class="offer-body">
                        <span class="offer-label">Member Benefit</span>
                        <h3>Long Stay Rewards</h3>
                        <p>Enjoy exclusive value on extended stays, room upgrades, and personalized concierge calls.</p>
                        <a href="{{ route('frontend.contact') }}" class="theme-btn">Explore Benefits</a>
                    </div>
                </article>
            </div>
        </div>
    </section>

    <style>
        .hotel-page-hero {
            background: linear-gradient(135deg, rgba(12, 20, 38, 0.9), rgba(31, 54, 82, 0.84));
            padding: 80px 0 40px;
            color: #fff;
        }

        .hero-inner {
            max-width: 720px;
        }

        .section-tag {
            display: inline-block;
            font-size: 12px;
            letter-spacing: 0.18em;
            text-transform: uppercase;
            font-weight: 700;
            color: #d4af37;
            margin-bottom: 16px;
        }

        .hotel-page-hero h1 {
            font-size: clamp(2.2rem, 5vw, 4rem);
            font-weight: 800;
            margin: 0 0 12px;
        }

        .hotel-page-hero p {
            font-size: 1.08rem;
            color: rgba(255, 255, 255, 0.84);
            max-width: 620px;
            margin: 0;
        }

        .offers-wrapper {
            padding: 60px 0 80px;
            background: #f6f7f9;
        }

        .offers-grid {
            display: grid;
            grid-template-columns: repeat(2, minmax(0, 1fr));
            gap: 26px;
        }

        .offer-card {
            display: flex;
            align-items: center;
            gap: 18px;
            background: #ffffff;
            border: 1px solid rgba(15, 23, 42, 0.08);
            border-radius: 20px;
            padding: 22px;
            box-shadow: 0 18px 40px rgba(15, 23, 42, 0.06);
        }

        .offer-card.featured {
            background: linear-gradient(135deg, rgba(245, 255, 249, 0.96), rgba(240, 247, 255, 0.96));
        }

        .offer-date {
            min-width: 96px;
            height: 110px;
            border-radius: 16px;
            background: linear-gradient(180deg, #0d1b2a 0%, #172a3a 100%);
            color: #fff;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            text-align: center;
        }

        .offer-date span {
            font-size: 12px;
            text-transform: uppercase;
            letter-spacing: 0.12em;
            opacity: 0.8;
        }

        .offer-date strong {
            font-size: 2rem;
            line-height: 1;
            margin-top: 8px;
            font-weight: 800;
        }

        .offer-body {
            flex: 1;
        }

        .offer-label {
            display: inline-block;
            background: rgba(212, 175, 55, 0.14);
            color: #8c6a2d;
            border: 1px solid rgba(212, 175, 55, 0.25);
            border-radius: 999px;
            padding: 6px 10px;
            font-size: 11px;
            font-weight: 700;
            letter-spacing: 0.08em;
            text-transform: uppercase;
            margin-bottom: 10px;
        }

        .offer-body h3 {
            margin: 0 0 8px;
            font-size: 2rem;
            font-weight: 800;
            color: #111827;
        }

        .offer-body p {
            margin: 0 0 16px;
            color: #48505b;
            line-height: 1.7;
        }

        .theme-btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            background: #d4af37;
            color: #fff;
            border-radius: 10px;
            padding: 12px 18px;
            font-weight: 700;
            text-decoration: none;
            transition: 0.2s ease;
        }

        .theme-btn:hover {
            background: #b8921f;
            color: #fff;
            text-decoration: none;
        }

        @media (max-width: 767px) {
            .offers-grid {
                grid-template-columns: 1fr;
            }

            .offer-card {
                flex-direction: column;
                align-items: flex-start;
            }

            .offer-date {
                width: 100%;
                min-width: 100%;
                height: 90px;
            }
        }
    </style>
@endsection
