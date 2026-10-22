@extends('frontend.layouts.app')

@section('title', 'About Us | Hotel Luxura Palace')
@section('navbar_mode', 'transparent')

@push('after-styles')
    <style>
        .ab {
            --gold: #a9825c;
            --gold-d: #8a6a47;
            --ink: #2b2621;
            --mute: #6f665a;
            --cream: #f7f2ea;
            --card: #fffdfa;
            --line: #e5dccb;
            color: var(--ink);
            background: var(--card);
            font-family: 'Jost', sans-serif;
        }

        .ab * {
            box-sizing: border-box;
        }

        .ab h1,
        .ab h2,
        .ab h3 {
            font-family: 'Playfair Display', serif;
            font-weight: 700;
            margin: 0;
        }

        .ab-wrap {
            width: min(1140px, calc(100% - 40px));
            margin: auto;
        }

        .ab-sec {
            padding: 80px 0;
        }

        .ab-sec.alt {
            background: var(--cream);
        }

        .ab-head {
            max-width: 620px;
            margin-bottom: 40px;
        }

        .ab-head.c {
            margin-left: auto;
            margin-right: auto;
            text-align: center;
        }

        .ab-head h2 {
            font-size: clamp(28px, 3.2vw, 38px);
            line-height: 1.2;
            margin-bottom: 10px;
        }

        .ab-head p {
            margin: 0;
            color: var(--mute);
            font-size: 16px;
            line-height: 1.7;
        }

        .ab-btn {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 13px 26px;
            border-radius: 8px;
            border: 1px solid var(--ink);
            background: var(--ink);
            color: #fff !important;
            font-size: 13px;
            font-weight: 700;
            letter-spacing: 1px;
            text-transform: uppercase;
            text-decoration: none !important;
            transition: .2s;
        }

        .ab-btn:hover {
            background: var(--gold);
            border-color: var(--gold);
        }

        .ab-btn.ghost {
            background: transparent;
            color: var(--ink) !important;
        }

        .ab-btn.ghost:hover {
            background: var(--ink);
            color: #fff !important;
        }

        .ab a:focus-visible,
        .ab button:focus-visible,
        .ab summary:focus-visible,
        .ab input:focus-visible,
        .ab select:focus-visible {
            outline: 2px solid var(--gold);
            outline-offset: 2px;
        }

        /* Hero */
        .ab-hero {
            background: linear-gradient(90deg, rgba(43, 38, 33, .82), rgba(43, 38, 33, .45)), url('https://images.unsplash.com/photo-1566073771259-6a8506099945?auto=format&fit=crop&w=1800&q=80') center/cover;
            color: #fff;
            padding: 190px 0 130px;
        }

        .ab-hero h1 {
            color: #fff;
            font-size: clamp(36px, 5vw, 58px);
            line-height: 1.1;
            max-width: 680px;
        }

        .ab-hero p {
            max-width: 520px;
            margin: 16px 0 28px;
            color: #ece3d4;
            font-size: 17px;
            line-height: 1.7;
        }

        .ab-hero .ab-btn {
            background: var(--gold);
            border-color: var(--gold);
        }

        .ab-hero .ab-btn:hover {
            background: #fff;
            border-color: #fff;
            color: var(--ink) !important;
        }

        .ab-hero .ab-btn.ghost {
            background: transparent;
            border-color: rgba(255, 255, 255, .6);
            color: #fff !important;
            margin-left: 10px;
        }

        .ab-hero .ab-btn.ghost:hover {
            background: #fff;
            color: var(--ink) !important;
        }

        /* Overlap card */
        .ab-book {
            position: relative;
            z-index: 2;
            margin-top: -56px;
        }

        /* Story */
        .ab-story {
            display: grid;
            grid-template-columns: 1.1fr .9fr;
            gap: 60px;
            align-items: center;
        }

        .ab-story h2 {
            font-size: clamp(28px, 3.2vw, 38px);
            line-height: 1.2;
            margin-bottom: 18px;
        }

        .ab-story p {
            margin: 0 0 14px;
            color: var(--mute);
            font-size: 16px;
            line-height: 1.85;
        }

        .ab-facts {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 0 28px;
            margin: 22px 0 26px;
            padding: 0;
            list-style: none;
        }

        .ab-facts li {
            display: flex;
            justify-content: space-between;
            gap: 10px;
            padding: 11px 0;
            border-bottom: 1px solid var(--line);
            font-size: 14px;
        }

        .ab-facts span {
            color: var(--mute);
        }

        .ab-facts b {
            color: var(--ink);
        }

        .ab-photo {
            position: relative;
        }

        .ab-photo img {
            display: block;
            width: 100%;
            height: 480px;
            object-fit: cover;
            border-radius: 14px;
        }

        .ab-photo figcaption {
            position: absolute;
            left: -24px;
            bottom: 28px;
            max-width: 230px;
            padding: 16px 18px;
            background: var(--ink);
            color: #fff;
            border-radius: 10px;
            border-left: 4px solid var(--gold);
            font-size: 14px;
            line-height: 1.5;
        }

        .ab-photo figcaption b {
            display: block;
            margin-bottom: 3px;
            font: 700 20px 'Playfair Display', serif;
        }

        /* Stats */
        .ab-stats {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            background: var(--card);
            border: 1px solid var(--line);
            border-radius: 14px;
            box-shadow: 0 18px 40px rgba(43, 38, 33, .12);
        }

        .ab-stat {
            padding: 28px 20px;
            text-align: center;
            border-left: 1px solid var(--line);
        }

        .ab-stat:first-child {
            border-left: 0;
        }

        .ab-stat b {
            display: block;
            font: 700 38px/1.1 'Playfair Display', serif;
            color: var(--gold-d);
        }

        .ab-stat span {
            color: var(--mute);
            font-size: 14px;
        }

        /* Values */
        .ab-values {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 34px 36px;
        }

        .ab-val {
            padding-top: 20px;
            border-top: 2px solid var(--gold);
        }

        .ab-val i {
            color: var(--gold);
            font-size: 22px;
            margin-bottom: 14px;
            display: block;
        }

        .ab-val h3 {
            font-size: 20px;
            margin-bottom: 8px;
        }

        .ab-val p {
            margin: 0;
            color: var(--mute);
            font-size: 15px;
            line-height: 1.75;
        }

        /* Facilities */
        .ab-fac {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 0 30px;
        }

        .ab-fac div {
            display: flex;
            align-items: center;
            gap: 14px;
            padding: 16px 0;
            border-bottom: 1px solid var(--line);
            font-size: 15px;
            font-weight: 500;
        }

        .ab-fac i {
            flex: 0 0 38px;
            height: 38px;
            display: grid;
            place-items: center;
            border-radius: 50%;
            background: #f1e7d7;
            color: var(--gold-d);
            font-size: 15px;
        }

        /* Timeline */
        .ab-tl {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 28px;
            margin: 0;
            padding: 0;
            list-style: none;
        }

        .ab-tl li {
            position: relative;
            padding-top: 26px;
            border-top: 2px solid var(--line);
        }

        .ab-tl li::before {
            content: "";
            position: absolute;
            top: -7px;
            left: 0;
            width: 12px;
            height: 12px;
            border-radius: 50%;
            background: var(--gold);
            box-shadow: 0 0 0 4px var(--cream);
        }

        .ab-tl b {
            display: block;
            font: 700 26px 'Playfair Display', serif;
            color: var(--gold-d);
        }

        .ab-tl h3 {
            font-size: 17px;
            margin: 6px 0;
        }

        .ab-tl p {
            margin: 0;
            color: var(--mute);
            font-size: 14px;
            line-height: 1.7;
        }

        /* Reviews */
        .ab-rev {
            display: grid;
            grid-template-columns: 320px 1fr;
            gap: 56px;
            align-items: start;
        }

        .ab-score b {
            display: block;
            font: 700 64px/1 'Playfair Display', serif;
        }

        .ab-stars {
            color: var(--gold);
            font-size: 20px;
            letter-spacing: 3px;
            margin: 8px 0 4px;
        }

        .ab-score p {
            margin: 0 0 20px;
            color: var(--mute);
            font-size: 14px;
        }

        .ab-bar {
            display: grid;
            grid-template-columns: 18px 1fr 36px;
            gap: 10px;
            align-items: center;
            margin-bottom: 8px;
            font-size: 13px;
            color: var(--mute);
        }

        .ab-bar i {
            display: block;
            height: 7px;
            border-radius: 7px;
            background: var(--line);
            overflow: hidden;
        }

        .ab-bar i::after {
            content: "";
            display: block;
            height: 100%;
            width: var(--w);
            background: var(--gold);
        }

        .ab-quote {
            padding: 24px 0;
            border-bottom: 1px solid var(--line);
        }

        .ab-quote:first-child {
            padding-top: 0;
        }

        .ab-quote:last-child {
            border-bottom: 0;
            padding-bottom: 0;
        }

        .ab-quote .ab-stars {
            font-size: 15px;
            margin: 0 0 10px;
        }

        .ab-quote p {
            margin: 0 0 12px;
            font-size: 17px;
            line-height: 1.75;
        }

        .ab-quote small {
            color: var(--mute);
            font-size: 13px;
        }

        .ab-quote small b {
            color: var(--ink);
        }

        /* FAQ */
        .ab-faq {
            max-width: 780px;
            margin: auto;
        }

        .ab-faq details {
            border-bottom: 1px solid var(--line);
        }

        .ab-faq summary {
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 16px;
            padding: 20px 0;
            cursor: pointer;
            font-size: 17px;
            font-weight: 600;
            list-style: none;
        }

        .ab-faq summary::-webkit-details-marker {
            display: none;
        }

        .ab-faq summary::after {
            content: "+";
            color: var(--gold);
            font-size: 24px;
            font-weight: 400;
            transition: transform .2s;
        }

        .ab-faq details[open] summary::after {
            transform: rotate(45deg);
        }

        .ab-faq details p {
            margin: 0;
            padding: 0 0 20px;
            color: var(--mute);
            font-size: 15px;
            line-height: 1.8;
        }

        /* Contact + CTA */
        .ab-cta {
            display: grid;
            grid-template-columns: 1fr 1.1fr;
            gap: 48px;
            padding: 48px;
            background: var(--ink);
            color: #fff;
            border-radius: 18px;
        }

        .ab-cta h2 {
            color: #fff;
            font-size: clamp(26px, 3vw, 34px);
            line-height: 1.25;
            margin-bottom: 12px;
        }

        .ab-cta p {
            margin: 0 0 24px;
            color: #d9cfbf;
            font-size: 16px;
            line-height: 1.7;
        }

        .ab-cta .ab-btn {
            background: var(--gold);
            border-color: var(--gold);
        }

        .ab-cta .ab-btn:hover {
            background: #fff;
            border-color: #fff;
            color: var(--ink) !important;
        }

        .ab-cta .ab-btn.ghost {
            background: transparent;
            border-color: rgba(255, 255, 255, .5);
            color: #fff !important;
            margin-left: 8px;
        }

        .ab-cta .ab-btn.ghost:hover {
            background: #fff;
            color: var(--ink) !important;
        }

        .ab-info {
            display: grid;
            gap: 0;
            align-content: center;
        }

        .ab-info div {
            display: flex;
            gap: 16px;
            padding: 15px 0;
            border-bottom: 1px solid rgba(255, 255, 255, .14);
            font-size: 15px;
            line-height: 1.5;
        }

        .ab-info div:last-child {
            border-bottom: 0;
        }

        .ab-info i {
            flex: 0 0 20px;
            margin-top: 3px;
            color: var(--gold);
        }

        .ab-info small {
            display: block;
            color: #b9ad9a;
            font-size: 12px;
        }

        .ab-info {
            display: flex;
            flex-direction: column;
            gap: 10px;
        }

        .ab-info-item {
            position: relative;
            display: flex;
            align-items: center;
            gap: 17px;
            padding: 17px 16px;
            border: 1px solid rgba(201, 169, 119, 0.13);
            border-radius: 12px;
            background: rgba(255, 255, 255, 0.025);
            color: inherit;
            text-decoration: none !important;
            transition:
                background .3s ease,
                border-color .3s ease,
                transform .3s ease,
                box-shadow .3s ease;
        }

        .ab-info-item>i:first-child {
            flex: 0 0 42px;
            width: 42px;
            height: 42px;
            display: grid;
            place-items: center;
            border-radius: 11px;
            background: rgba(201, 169, 119, 0.10);
            color: #c9a977;
            font-size: 16px;
            transition: background .3s ease, color .3s ease;
        }

        .ab-info-item>span:first-of-type {
            min-width: 0;
            display: flex;
            flex-direction: column;
            gap: 5px;
            font-size: 13px;
            line-height: 1.65;
            overflow-wrap: anywhere;
        }

        .ab-info-item small {
            color: #c9a977;
            font-size: 10px;
            font-weight: 700;
            letter-spacing: 1.8px;
            text-transform: uppercase;
        }

        .ab-info a:hover,
        .ab-info a:focus-visible {
            color: inherit;
            background: rgba(201, 169, 119, 0.09);
            border-color: rgba(201, 169, 119, 0.55);
            transform: translateX(5px);
            box-shadow: 0 8px 24px rgba(0, 0, 0, 0.08);
            outline: none;
        }

        .ab-info a:hover>i:first-child,
        .ab-info a:focus-visible>i:first-child {
            background: #c9a977;
            color: #171916;
        }

        .ab-info-arrow {
            margin-left: auto;
            color: #c9a977;
            font-size: 11px;
            opacity: 0;
            transform: translate(-4px, 4px);
            transition: opacity .25s ease, transform .25s ease;
        }

        .ab-info a:hover .ab-info-arrow,
        .ab-info a:focus-visible .ab-info-arrow {
            opacity: 1;
            transform: translate(0, 0);
        }

        .ab-open-status {
            margin-left: auto;
            display: inline-flex;
            align-items: center;
            gap: 6px;
            white-space: nowrap;
            color: #86b99a;
            font-size: 10px;
            font-weight: 700;
            letter-spacing: 1px;
        }

        .ab-open-status span {
            width: 7px;
            height: 7px;
            border-radius: 50%;
            background: #86b99a;
            box-shadow: 0 0 0 4px rgba(134, 185, 154, 0.12);
        }

        @media (max-width: 480px) {
            .ab-info-item {
                gap: 12px;
                padding: 14px 12px;
            }

            .ab-info-item>i:first-child {
                flex-basis: 36px;
                width: 36px;
                height: 36px;
            }

            .ab-info-arrow {
                display: none;
            }
        }

        @media (prefers-reduced-motion: reduce) {

            .ab-info-item,
            .ab-info-item>i:first-child,
            .ab-info-arrow {
                transition: none;
            }
        }

        /* Reception card — align with the other contact cards */
        .ab-info .ab-info-static {
            min-height: 91px;
            box-sizing: border-box;
            display: flex;
            align-items: center;
            gap: 17px;
            padding: 17px 16px;
        }

        .ab-info .ab-info-static>i:first-child {
            flex: 0 0 42px;
            width: 42px;
            height: 42px;
            display: grid;
            place-items: center;
            border-radius: 11px;
        }

        .ab-info .ab-info-static .ab-info-text {
            flex: 1;
            min-width: 0;
            display: flex;
            flex-direction: column;
            gap: 5px;
            line-height: 1.65;
        }

        .ab-info .ab-info-static .ab-open-status {
            flex: 0 0 auto;
            margin-left: auto;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 7px;
            padding: 7px 10px;
            border: 1px solid rgba(134, 185, 154, .18);
            border-radius: 20px;
            background: rgba(134, 185, 154, .08);
            white-space: nowrap;
            line-height: 1;
        }

        .ab-info .ab-info-static .ab-status-dot {
            width: 7px;
            height: 7px;
            flex: 0 0 7px;
            border-radius: 50%;
            background: #86b99a;
            box-shadow: 0 0 0 3px rgba(134, 185, 154, .13);
        }

        @media (max-width: 480px) {
            .ab-info .ab-info-static {
                gap: 12px;
                padding: 14px 12px;
            }

            .ab-info .ab-info-static>i:first-child {
                flex-basis: 36px;
                width: 36px;
                height: 36px;
            }

            .ab-info .ab-info-static .ab-open-status {
                padding: 6px 8px;
                font-size: 9px;
            }
        }


        @media (max-width:991px) {

            .ab-story,
            .ab-rev,
            .ab-cta {
                grid-template-columns: 1fr;
                gap: 36px;
            }

            .ab-photo figcaption {
                left: 16px;
            }

            .ab-values {
                grid-template-columns: repeat(2, 1fr);
            }

            .ab-fac {
                grid-template-columns: repeat(3, 1fr);
            }

            .ab-tl {
                grid-template-columns: repeat(2, 1fr);
                gap: 36px 28px;
            }
        }

        @media (max-width:600px) {
            .ab-sec {
                padding: 56px 0;
            }

            .ab-hero {
                padding: 150px 0 110px;
            }

            .ab-hero .ab-btn.ghost,
            .ab-cta .ab-btn.ghost {
                margin: 10px 0 0;
            }

            .ab-photo img {
                height: 340px;
            }

            .ab-facts,
            .ab-values,
            .ab-tl {
                grid-template-columns: 1fr;
            }

            .ab-stats {
                grid-template-columns: repeat(2, 1fr);
            }

            .ab-stat:nth-child(3) {
                border-left: 0;
            }

            .ab-stat:nth-child(n+3) {
                border-top: 1px solid var(--line);
            }

            .ab-fac {
                grid-template-columns: repeat(2, 1fr);
                gap: 0 16px;
            }

            .ab-cta {
                padding: 30px 22px;
            }

            .ab-btn {
                width: 100%;
                justify-content: center;
            }
        }
    </style>
@endpush

@section('content')
    @php
        // NOTE: Sample content. Apne hotel ke asli numbers, reviews aur contact details se replace karo
        // (ya database se $stats / $reviews pass karo).
        $stats = [['12+', 'Years of hospitality'], ['120', 'Rooms and suites'], ['25k+', 'Guests hosted'], ['4.8', 'Average guest rating']];

        $values = [
            ['fa-concierge-bell', 'Attentive service', 'Our front desk is available around the clock for requests, local tips and late arrivals.'],
            ['fa-bed', 'Rooms made for rest', 'Quality bedding, blackout curtains and quiet floors, so you sleep well after a long day.'],
            ['fa-utensils', 'Good food, any hour', 'Breakfast, regional dishes and in-room dining, prepared fresh by our own kitchen.'],
            ['fa-shield-alt', 'Safe and secure', 'Round-the-clock security, CCTV in public areas and a secure check-in for every guest.'],
            ['fa-map-marker-alt', 'Easy to reach', 'Close to main roads, transport links and the places most guests come to see.'],
            ['fa-tag', 'Clear pricing', 'The price you see when you book is the price you pay, with no surprise charges at checkout.'],
        ];

        $amenities = [
            ['fa-wifi', 'Free Wi-Fi'],
            ['fa-swimming-pool', 'Swimming pool'],
            ['fa-spa', 'Spa and wellness'],
            ['fa-dumbbell', 'Fitness centre'],
            ['fa-utensils', 'Restaurant'],
            ['fa-coffee', 'Daily breakfast'],
            ['fa-parking', 'Free parking'],
            ['fa-shuttle-van', 'Airport pickup'],
            ['fa-snowflake', 'Air conditioning'],
            ['fa-tv', 'Smart TV'],
            ['fa-concierge-bell', 'Room service'],
            ['fa-briefcase', 'Business centre'],
        ];

        $timeline = [
            ['2012', 'We opened our doors', 'Started as a small family-run hotel with just 20 rooms.'],
            ['2016', 'Pool and restaurant', 'Added a pool deck and our own kitchen for in-house dining.'],
            ['2020', 'Every room renovated', 'New interiors, fittings and bedding across all floors.'],
            ['2024', 'Online booking', 'Guests can now check availability and book directly on this site.'],
        ];

        $ratings = [5 => 78, 4 => 16, 3 => 4, 2 => 1, 1 => 1];

        $reviews = [
            ['Quiet room, friendly staff and a breakfast that was better than I expected. Check-in took less than five minutes even though we arrived late at night.', 'Rohan M.', 'Business trip'],
            ['We stayed with our two kids and the staff went out of their way to help. The pool was clean and the room was spacious enough for all of us.', 'Priya S.', 'Family stay'],
            ['Booking online was simple and the price matched what I paid at checkout. Easy to reach from the highway and the parking was free.', 'Ahmed K.', 'Weekend getaway'],
        ];

        $faqs = [
            ['What are the check-in and check-out times?', 'Check-in starts at 2:00 PM and check-out is until 11:00 AM. If you need to arrive early or leave late, send us an inquiry and we will do our best to arrange it.'],
            ['Can I cancel or change my booking?', 'You can manage your bookings from your account. Cancellation terms depend on the room and dates you choose, and they are shown before you confirm.'],
            ['Is breakfast included?', 'Breakfast is available daily. Whether it is included depends on the room option you pick, which is listed on the room page.'],
            ['Do you offer airport pickup?', 'Yes, we can arrange pickup on request. Please tell us your flight details at least a day before arrival.'],
            ['How do I contact the hotel before I book?', 'Use the contact form to send us a message. You can follow the hotel’s reply any time from My Inquiries in your account.'],
        ];
    @endphp

    <main class="ab">

        {{-- Hero --}}
        <section class="ab-hero">
            <div class="ab-wrap">
                <h1>A calm, comfortable stay at Hotel Luxura Palace</h1>
                <p>Well-kept rooms, warm service and honest pricing, for business trips, family holidays and everything in
                    between.</p>
                <a href="{{ route('frontend.room.index') }}" class="ab-btn">Explore rooms</a>
                <a href="{{ route('frontend.contact') }}" class="ab-btn ghost">Contact us</a>
            </div>
        </section>

        {{-- Stats card (hero par overlap) --}}
        <div class="ab-book">
            <div class="ab-wrap">
                <div class="ab-stats">
                    @foreach($stats as [$num, $label])
                        <div class="ab-stat"><b>{{ $num }}</b><span>{{ $label }}</span></div>
                    @endforeach
                </div>
            </div>
        </div>

        {{-- Story --}}
        <section class="ab-sec">
            <div class="ab-wrap">
                <div class="ab-story">
                    <div>
                        <h2>Our story</h2>
                        <p>Hotel Luxura Palace began as a small family-run hotel with one idea: a good stay starts with a
                            welcoming atmosphere and a room that feels right. Over the years we have grown, but we still run
                            the hotel the same way, with guests first.</p>
                        <p>Whether you are travelling for work, taking a break or spending time with family, we want
                            planning your stay to be simple. Pick your dates, compare the available rooms and book directly
                            with us.</p>
                        <ul class="ab-facts">
                            <li><span>Check-in</span><b>From 2:00 PM</b></li>
                            <li><span>Check-out</span><b>Until 11:00 AM</b></li>
                            <li><span>Reception</span><b>24 hours</b></li>
                            <li><span>Languages</span><b>English, Hindi</b></li>
                        </ul>
                        <a href="{{ route('frontend.room.index') }}" class="ab-btn">View available rooms</a>
                    </div>
                    <figure class="ab-photo m-0">
                        <img src="https://images.unsplash.com/photo-1611892440504-42a792e24d32?auto=format&fit=crop&w=900&q=80"
                            alt="Comfortable bedroom at Hotel Luxura Palace" loading="lazy">
                        <figcaption><b>Guests first</b>Every room is checked and prepared before you arrive.</figcaption>
                    </figure>
                </div>

            </div>
        </section>

        {{-- Why stay with us --}}
        <section class="ab-sec alt">
            <div class="ab-wrap">
                <div class="ab-head">
                    <h2>Why guests choose us</h2>
                    <p>Small things done properly, every day. This is what you can expect from your stay.</p>
                </div>
                <div class="ab-values">
                    @foreach($values as [$icon, $title, $text])
                        <div class="ab-val">
                            <i class="fas {{ $icon }}"></i>
                            <h3>{{ $title }}</h3>
                            <p>{{ $text }}</p>
                        </div>
                    @endforeach
                </div>
            </div>
        </section>

        {{-- Facilities --}}
        <section class="ab-sec">
            <div class="ab-wrap">
                <div class="ab-head">
                    <h2>Facilities and amenities</h2>
                    <p>Everything you need for a comfortable stay is included on site.</p>
                </div>
                <div class="ab-fac">
                    @foreach($amenities as [$icon, $label])
                        <div><i class="fas {{ $icon }}"></i>{{ $label }}</div>
                    @endforeach
                </div>
            </div>
        </section>

        {{-- Journey --}}
        <section class="ab-sec alt">
            <div class="ab-wrap">
                <div class="ab-head">
                    <h2>How we got here</h2>
                    <p>A few milestones from our journey so far.</p>
                </div>
                <ol class="ab-tl">
                    @foreach($timeline as [$year, $title, $text])
                        <li><b>{{ $year }}</b>
                            <h3>{{ $title }}</h3>
                            <p>{{ $text }}</p>
                        </li>
                    @endforeach
                </ol>
            </div>
        </section>

        {{-- Reviews --}}
        <section class="ab-sec">
            <div class="ab-wrap">
                <div class="ab-head">
                    <h2>What our guests say</h2>
                    <p>Honest feedback from people who stayed with us.</p>
                </div>
                <div class="ab-rev">
                    <div class="ab-score">
                        <b>4.8</b>
                        <div class="ab-stars" aria-label="4.8 out of 5">★★★★★</div>
                        <p>Based on 1,240 guest reviews</p>
                        @foreach($ratings as $star => $pct)
                            <div class="ab-bar"><span>{{ $star }}</span><i style="--w:{{ $pct }}%"></i><span>{{ $pct }}%</span>
                            </div>
                        @endforeach
                    </div>
                    <div>
                        @foreach($reviews as [$text, $name, $trip])
                            <blockquote class="ab-quote m-0">
                                <div class="ab-stars" aria-label="5 out of 5">★★★★★</div>
                                <p>{{ $text }}</p>
                                <small><b>{{ $name }}</b> · {{ $trip }}</small>
                            </blockquote>
                        @endforeach
                    </div>
                </div>
            </div>
        </section>

        {{-- FAQ --}}
        <section class="ab-sec alt">
            <div class="ab-wrap">
                <div class="ab-head c">
                    <h2>Before you book</h2>
                    <p>Quick answers to the questions guests ask most.</p>
                </div>
                <div class="ab-faq">
                    @foreach($faqs as [$q, $a])
                        <details>
                            <summary>{{ $q }}</summary>
                            <p>{{ $a }}</p>
                        </details>
                    @endforeach
                </div>
            </div>
        </section>

        {{-- Contact + CTA --}}
        <section class="ab-sec">
            <div class="ab-wrap">
                <div class="ab-cta">
                    <div>
                        <h2>Ready to plan your stay?</h2>
                        <p>Check availability for your dates, or send us a message and we will get back to you.</p>
                        <a href="{{ route('frontend.room.index') }}" class="ab-btn">Book your stay</a>
                        <a href="{{ route('frontend.contact') }}" class="ab-btn ghost">Send an inquiry</a>
                    </div>

                    <div class="ab-info">

                        <a href="#" target="_blank"
                            rel="noopener noreferrer" class="ab-info-item">
                            <i class="fas fa-map-marker-alt"></i>
                            <span>
                                <small>Address</small>
                                Hotel Luxura Palace, Your Street, Your City
                            </span>
                            <i class="fas fa-arrow-up-right-from-square ab-info-arrow"></i>
                        </a>

                        <a href="tel:+91-9316449257" class="ab-info-item">
                            <i class="fas fa-phone"></i>
                            <span>
                                <small>Phone</small>
                                +91 9316449257
                            </span>
                            <i class="fas fa-arrow-up-right-from-square ab-info-arrow"></i>
                        </a>

                        <a href="mailto:info@hotelluxura.com" class="ab-info-item">
                            <i class="fas fa-envelope"></i>
                            <span>
                                <small>Email</small>
                                haidarmaknojiya1306@gmail.com
                            </span>
                            <i class="fas fa-arrow-up-right-from-square ab-info-arrow"></i>
                        </a>

                        <div class="ab-info-item ab-info-static">
                            <i class="fas fa-clock"></i>

                            <span class="ab-info-text">
                                <small>Reception</small>
                                Open 24 hours, every day
                            </span>

                            <span class="ab-open-status">
                                <span class="ab-status-dot"></span>
                                24/7
                            </span>
                        </div>

                    </div>

                </div>
            </div>
        </section>

    </main>
@endsection