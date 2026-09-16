@extends('frontend.layouts.app')

@section('title', 'Hotel Updates')

@push('after-styles')
<style>
    /* ===========================
       UPDATES HERO
    =========================== */

    .updates-hero {
        position: relative;
        width: 100%;
        min-height: 38vh;
        display: flex;
        align-items: center;
        justify-content: center;
        background:
            linear-gradient(180deg, rgba(43,38,33,.55) 0%, rgba(43,38,33,.80) 100%),
            url('https://images.unsplash.com/photo-1618773928121-c32242e63f39?w=1920') center/cover no-repeat;
        text-align: center;
        margin-bottom: 60px;
    }

    .updates-hero span.kicker {
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

    .updates-hero h1 {
        font-family: 'Playfair Display', serif;
        font-size: clamp(2.2rem, 5vw, 3.4rem);
        font-weight: 700;
        color: #fffdfa;
        margin: 0 0 12px;
    }

    .updates-hero p {
        max-width: 560px;
        margin: 0 auto;
        color: #e8dcc8;
        font-size: 16px;
        line-height: 1.8;
    }

    /* ===========================
       UPDATE CARDS (with images)
    =========================== */

    .updates-wrapper {
        padding: 0 0 70px;
        background: #f7f2ea;
    }

    .updates-grid {
        display: grid;
        grid-template-columns: repeat(3, minmax(0, 1fr));
        gap: 26px;
        margin-bottom: 50px;
    }

    .update-card {
        background: #fffdfa;
        border: 1px solid #e5dccb;
        border-radius: 14px;
        overflow: hidden;
        transition: transform .25s ease, box-shadow .25s ease;
    }

    .update-card:hover {
        transform: translateY(-6px);
        box-shadow: 0 18px 36px rgba(43, 38, 33, .10);
    }

    .update-image {
        position: relative;
        height: 170px;
        background-size: cover;
        background-position: center;
    }

    .update-image-caption {
        position: absolute;
        left: 16px;
        bottom: 14px;
        color: #fffdfa;
    }

    .update-image-caption .tag {
        display: inline-block;
        background: #a9825c;
        color: #fff;
        font-size: 10px;
        font-weight: 700;
        letter-spacing: 0.08em;
        text-transform: uppercase;
        padding: 4px 10px;
        border-radius: 999px;
        margin-bottom: 6px;
    }

    .update-image-caption .caption-title {
        display: block;
        font-family: 'Playfair Display', serif;
        font-size: 17px;
        font-weight: 700;
        line-height: 1.2;
    }

    .update-body {
        padding: 18px 20px 22px;
    }

    .update-meta {
        display: flex;
        align-items: center;
        justify-content: space-between;
        margin-bottom: 12px;
    }

    .update-category {
        font-size: 11px;
        font-weight: 700;
        letter-spacing: 0.08em;
        text-transform: uppercase;
        color: #a9825c;
    }

    .update-date {
        font-size: 12px;
        color: #8a7f6f;
    }

    .update-date i {
        margin-right: 5px;
        color: #a9825c;
    }

    .update-body h3 {
        font-family: 'Playfair Display', serif;
        color: #2b2621;
        font-size: 19px;
        font-weight: 700;
        margin-bottom: 10px;
    }

    .update-body p {
        color: #8a7f6f;
        font-size: 13.5px;
        line-height: 1.7;
        margin-bottom: 16px;
    }

    .update-read-more {
        display: inline-flex;
        align-items: center;
        gap: 7px;
        font-size: 12.5px;
        font-weight: 700;
        letter-spacing: 0.05em;
        text-transform: uppercase;
        color: #a9825c;
        text-decoration: none;
        transition: gap 0.25s;
    }

    .update-read-more:hover {
        gap: 12px;
        color: #8a6844;
        text-decoration: none;
    }

    /* ===========================
       NEWSLETTER BAR
    =========================== */

    .updates-newsletter {
        background: #f0e6d4;
        border-radius: 16px;
        padding: 28px 32px;
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 24px;
        flex-wrap: wrap;
    }

    .newsletter-left {
        display: flex;
        align-items: center;
        gap: 16px;
        flex: 1;
        min-width: 260px;
    }

    .newsletter-icon {
        width: 48px;
        height: 48px;
        min-width: 48px;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 50%;
        background: #a9825c;
        color: #fff;
        font-size: 18px;
    }

    .newsletter-left h5 {
        font-family: 'Playfair Display', serif;
        color: #2b2621;
        font-size: 17px;
        font-weight: 700;
        margin: 0 0 4px;
    }

    .newsletter-left p {
        color: #6b5a3e;
        font-size: 13px;
        margin: 0;
    }

    .newsletter-form {
        display: flex;
        gap: 10px;
        flex: 1;
        min-width: 280px;
    }

    .newsletter-form input {
        flex: 1;
        border: 1px solid #d9c4a5;
        border-radius: 8px;
        padding: 12px 16px;
        font-size: 14px;
        background: #fffdfa;
        color: #3a352e;
    }

    .newsletter-form input:focus {
        outline: none;
        border-color: #a9825c;
    }

    .newsletter-form button {
        background: #a9825c;
        color: #fff;
        border: none;
        border-radius: 8px;
        padding: 12px 26px;
        font-size: 13px;
        font-weight: 600;
        letter-spacing: 0.03em;
        text-transform: uppercase;
        cursor: pointer;
        transition: 0.25s;
    }

    .newsletter-form button:hover {
        background: #8a6844;
    }

    .newsletter-social {
        display: flex;
        align-items: center;
        gap: 12px;
    }

    .newsletter-social span {
        color: #6b5a3e;
        font-size: 13px;
        font-weight: 600;
        margin-right: 4px;
    }

    .newsletter-social a {
        width: 36px;
        height: 36px;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 50%;
        background: #2b2621;
        color: #f0e6d4;
        font-size: 14px;
        text-decoration: none;
        transition: 0.25s;
    }

    .newsletter-social a:hover {
        background: #a9825c;
        color: #fff;
    }

    @media (max-width: 991.98px) {
        .updates-grid {
            grid-template-columns: 1fr 1fr;
        }
    }

    @media (max-width: 767.98px) {
        .updates-grid {
            grid-template-columns: 1fr;
        }

        .updates-newsletter {
            flex-direction: column;
            align-items: stretch;
            text-align: center;
        }

        .newsletter-left {
            flex-direction: column;
            text-align: center;
        }

        .newsletter-form {
            flex-direction: column;
        }

        .newsletter-social {
            justify-content: center;
        }
    }
</style>
@endpush

@section('content')

    <section class="updates-hero page-hero">
        <div class="container">
            <span class="kicker">Latest Updates</span>
            <h1>Hotel Updates</h1>
            <p>Stay in tune with our latest experiences, renovations, seasonal highlights, and guest-first enhancements.</p>
        </div>
    </section>

    <section class="updates-wrapper">
        <div class="container">

            <div class="updates-grid">

                @php
                    $updates = [
                        ['image' => 'https://images.unsplash.com/photo-1566073771259-6a8506099945?w=700', 'tag' => 'Special Offer', 'category' => 'Offers', 'date' => '15 Sep 2026', 'title' => '15% Off on All Room Types', 'text' => 'Plan your next getaway with us and enjoy 15% off on all room types.'],
                        ['image' => 'https://images.unsplash.com/photo-1517248135467-4c7edcad34c4?w=700', 'tag' => 'Events', 'category' => 'Events', 'date' => '10 Sep 2026', 'title' => 'Romantic Dinner by the Pool', 'text' => 'Enjoy a special evening with your loved one at our poolside restaurant.'],
                        ['image' => 'https://images.unsplash.com/photo-1544161515-4ab6ce6db874?w=700', 'tag' => 'News', 'category' => 'News', 'date' => '05 Sep 2026', 'title' => 'New Spa & Wellness Services', 'text' => 'We are excited to introduce our new range of spa and wellness services.'],
                        ['image' => 'https://images.unsplash.com/photo-1505409859467-3a796fd5798e?w=700', 'tag' => 'Events', 'category' => 'Events', 'date' => '28 Aug 2026', 'title' => 'Conference Room Now Available', 'text' => 'Host your business meetings and events in our fully equipped conference room.'],
                        ['image' => 'https://images.unsplash.com/photo-1470071459604-3b5ec3a7fe05?w=700', 'tag' => 'Explore', 'category' => 'News', 'date' => '20 Aug 2026', 'title' => 'Local Travel Guide', 'text' => 'Discover the best places to visit and explore local attractions nearby.'],
                        ['image' => 'https://images.unsplash.com/photo-1533777857889-4be7c70b33f7?w=700', 'tag' => 'Offer', 'category' => 'Offers', 'date' => '12 Aug 2026', 'title' => 'Complimentary Breakfast', 'text' => 'Start your day with a delicious complimentary breakfast, included with your stay.'],
                    ];
                @endphp

                @foreach($updates as $update)

                    <div class="update-card">

                        <div class="update-image" style="background-image: url('{{ $update['image'] }}');">
                            <div class="update-image-caption">
                                <span class="tag">{{ $update['tag'] }}</span>
                            </div>
                        </div>

                        <div class="update-body">

                            <div class="update-meta">
                                <span class="update-category">{{ $update['category'] }}</span>
                                <span class="update-date"><i class="far fa-calendar"></i>{{ $update['date'] }}</span>
                            </div>

                            <h3>{{ $update['title'] }}</h3>
                            <p>{{ $update['text'] }}</p>

                            <a href="{{ route('frontend.contact') }}" class="update-read-more">
                                Read More &rarr;
                            </a>

                        </div>

                    </div>

                @endforeach

            </div>

            <div class="updates-newsletter">

                <div class="newsletter-left">
                    <div class="newsletter-icon">
                        <i class="fas fa-envelope"></i>
                    </div>
                    <div>
                        <h5>Stay Updated</h5>
                        <p>Subscribe to our newsletter and get the latest offers, updates and events directly in your inbox.</p>
                    </div>
                </div>

                <form class="newsletter-form">
                    <input type="email" placeholder="Enter your email address" required>
                    <button type="submit">Subscribe</button>
                </form>

                <div class="newsletter-social">
                    <span>Follow Us</span>
                    <a href="#"><i class="fab fa-facebook-f"></i></a>
                    <a href="#"><i class="fab fa-instagram"></i></a>
                    <a href="#"><i class="fab fa-youtube"></i></a>
                </div>

            </div>

        </div>
    </section>

@endsection