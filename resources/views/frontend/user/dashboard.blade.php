@extends('frontend.layouts.app')
<!-- public\css\frontend\user-dashboard.css -->
@push('after-styles')
    <link rel="stylesheet" href="{{ asset('css/frontend/user-dashboard.css') }}">
@endpush

@section('title', 'Dashboard')



@section('content')
    <style>
        .hero-section {
            position: relative;
            min-height: 100vh;

            background-image:
                linear-gradient(180deg,
                    rgba(7, 15, 26, .55) 0%,
                    rgba(7, 15, 26, .35) 45%,
                    rgba(7, 15, 26, .80) 100%),
                url('{{ asset("frontend/images/home.png") }}');


            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
            background-color: #0c2338;

            display: flex;
            align-items: center;
            justify-content: center;

            padding-top: 120px;
            text-align: center;

            overflow: hidden;
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

                <form id="searchForm" action="{{ route('frontend.room.index') }}" method="GET"
                    class="row align-items-start g-3" novalidate>

                    <div class="col-md-3">
                        <label for="room-search-check-in">Check In</label>
                        <input type="date" id="room-search-check-in" name="check_in"
                            class="form-control @error('check_in') is-invalid @enderror" min="{{ today()->toDateString() }}"
                            value="{{ old('check_in', request('check_in')) }}" required>

                        @error('check_in')
                            <span class="field-error">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="col-md-3">
                        <label for="room-search-check-out">Check Out</label>
                        <input type="date" id="room-search-check-out" name="check_out"
                            class="form-control @error('check_out') is-invalid @enderror"
                            min="{{ old('check_in', request('check_in')) ?: today()->toDateString() }}"
                            value="{{ old('check_out', request('check_out')) }}" required>

                        @error('check_out')
                            <span class="field-error">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="col-md-3">
                        <label for="guests">Guests</label>
                        <select name="guests" id="guests" class="form-control @error('guests') is-invalid @enderror"
                            required>
                            @for($guestCount = 1; $guestCount <= 20; $guestCount++)
                                <option value="{{ $guestCount }}" {{ (int) old('guests', request('guests', 1)) === $guestCount ? 'selected' : '' }}>
                                    {{ $guestCount }} {{ $guestCount === 1 ? 'Guest' : 'Guests' }}
                                </option>
                            @endfor
                        </select>

                        @error('guests')
                            <span class="field-error">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="col-md-3">
                        <label class="d-none d-md-block">&nbsp;</label>
                        <button type="submit" class="btn btn-gold w-100">
                            <i class="fas fa-search"></i>
                            Search Rooms
                        </button>
                    </div>

                </form>
                <div id="roomsResult" class="mt-4"></div>

            </div>

        </div>

    </section>
    @push('after-scripts')
        <script>
            document.addEventListener('DOMContentLoaded', function () {
                const checkIn = document.getElementById('room-search-check-in');
                const checkOut = document.getElementById('room-search-check-out');

                if (!checkIn || !checkOut) return;

                checkIn.addEventListener('change', function () {
                    checkOut.min = checkIn.value || '{{ today()->toDateString() }}';
                    if (checkOut.value && checkOut.value <= checkIn.value) {
                        checkOut.value = '';
                    }
                });
            });
        </script>
    @endpush
    <style>
        /* Hotel Luxura homepage sections — intentionally scoped below the hero */
        .lux-home {
            --lux-ink: #171a1c;
            --lux-muted: #687078;
            --lux-gold: #b78a45;
            --lux-cream: #f7f5f0;
            color: var(--lux-ink);
            background: #fff;
            overflow: hidden;
        }

        .lux-home * {
            box-sizing: border-box;
        }

        .lux-home .lux-wrap {
            width: min(1180px, calc(100% - 40px));
            margin: 0 auto;
        }

        .lux-home .lux-kicker {
            display: inline-flex;
            align-items: center;
            gap: 10px;
            color: var(--lux-gold);
            font-size: 11px;
            font-weight: 800;
            letter-spacing: .2em;
            text-transform: uppercase;
        }

        .lux-home .lux-kicker:before {
            content: "";
            width: 28px;
            height: 1px;
            background: currentColor;
        }

        .lux-home .lux-heading {
            margin: 12px 0 14px;
            color: var(--lux-ink);
            font-family: Georgia, "Times New Roman", serif;
            font-size: clamp(32px, 4vw, 48px);
            font-weight: 500;
            letter-spacing: -.035em;
            line-height: 1.12;
        }

        .lux-home .lux-lead {
            max-width: 650px;
            margin: 0;
            color: var(--lux-muted);
            font-size: 15px;
            line-height: 1.85;
        }

        .lux-home .lux-section {
            padding: 88px 0;
        }

        .lux-home .lux-section-head {
            margin-bottom: 38px;
        }

        .lux-home .lux-section-head.center {
            text-align: center;
        }

        .lux-home .lux-section-head.center .lux-lead {
            margin-inline: auto;
        }

        .lux-home .lux-btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 12px;
            min-height: 48px;
            padding: 0 22px;
            border: 1px solid var(--lux-gold);
            border-radius: 3px;
            background: var(--lux-gold);
            color: #fff !important;
            font-size: 12px;
            font-weight: 700;
            letter-spacing: .04em;
            text-decoration: none;
            transition: .25s ease;
        }

        .lux-home .lux-btn:hover {
            background: #956d31;
            border-color: #956d31;
            transform: translateY(-2px);
        }

        .lux-home .lux-btn-outline {
            background: transparent;
            color: var(--lux-ink) !important;
        }

        .lux-home .lux-btn-outline:hover {
            color: #fff !important;
        }

        .lux-home .lux-rooms {
            background: var(--lux-cream);
        }

        .lux-home .lux-room-grid {
            display: flex;
            gap: 22px;
            align-items: stretch;
            overflow-x: auto;
            overflow-y: hidden;
            padding: 4px 2px 22px;
            scroll-snap-type: x mandatory;
            scroll-padding: 2px;
            scrollbar-width: thin;
            scrollbar-color: #b78a45 #e8e3da;
            -webkit-overflow-scrolling: touch;
        }

        .lux-home .lux-room-grid::-webkit-scrollbar {
            height: 6px;
        }

        .lux-home .lux-room-grid::-webkit-scrollbar-track {
            background: #e8e3da;
            border-radius: 99px;
        }

        .lux-home .lux-room-grid::-webkit-scrollbar-thumb {
            background: #b78a45;
            border-radius: 99px;
        }

        .lux-home .lux-room-grid:focus-visible {
            outline: 2px solid #b78a45;
            outline-offset: 5px;
        }

        .lux-home .lux-room-scroll-hint {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 14px;
            margin: 2px 0 18px;
            color: #77736c;
            font-size: 11px;
            letter-spacing: .08em;
            text-transform: uppercase;
        }

        .lux-home .lux-room-scroll-hint span {
            display: inline-flex;
            align-items: center;
            gap: 8px;
        }

        .lux-home .lux-room-scroll-hint i {
            color: #a57939;
        }

        .lux-home .lux-room-card {
            flex: 0 0 clamp(285px, 31vw, 365px);
            min-width: 0;
            overflow: hidden;
            border-radius: 22px;
            background: #fff;
            border: 1px solid rgba(23, 26, 28, .08);
            scroll-snap-align: start;
            transition: transform .3s ease, box-shadow .3s ease;
        }

        .lux-home .lux-room-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 18px 40px rgba(25, 28, 30, .10);
        }

        .lux-home .lux-room-empty {
            min-width: min(100%, 420px);
            padding: 34px;
            border: 1px dashed #d9cbb5;
            border-radius: 20px;
            background: rgba(255, 255, 255, .65);
        }

        .lux-home .lux-room-empty>i {
            color: #b78a45;
            font-size: 26px;
        }

        .lux-home .lux-room-empty h3 {
            margin: 14px 0 8px;
            font: 500 24px Georgia, serif;
        }

        .lux-home .lux-room-empty p {
            color: var(--lux-muted);
            font-size: 13px;
        }

        .lux-home .lux-room-photo {
            position: relative;
            height: 245px;
            overflow: hidden;
            background: #e7e3dc;
        }

        .lux-home .lux-room-photo {
            height: 235px;
        }

        .lux-home .lux-room-card:first-child .lux-room-photo {
            height: 235px;
        }

        .lux-home .lux-room-photo img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            display: block;
            transition: transform .6s ease;
        }

        .lux-home .lux-room-card:hover .lux-room-photo img {
            transform: scale(1.045);
        }

        .lux-home .lux-room-label {
            position: absolute;
            left: 16px;
            top: 16px;
            padding: 7px 10px;
            background: rgba(255, 255, 255, .94);
            color: #4c3a20;
            font-size: 10px;
            font-weight: 800;
            letter-spacing: .1em;
            text-transform: uppercase;
        }

        .lux-home .lux-room-info {
            display: flex;
            flex-direction: column;
            padding: 22px;
            min-height: 265px;
        }

        .lux-home .lux-room-info p {
            flex: 1;
        }

        .lux-home .lux-room-meta {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 12px;
            color: var(--lux-muted);
            font-size: 11px;
            letter-spacing: .04em;
        }

        .lux-home .lux-room-info h3 {
            margin: 13px 0 9px;
            font: 500 25px/1.2 Georgia, "Times New Roman", serif;
        }

        .lux-home .lux-room-info p {
            min-height: 70px;
            margin: 0 0 20px;
            color: var(--lux-muted);
            font-size: 13px;
            line-height: 1.75;
        }

        .lux-home .lux-room-bottom {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 12px;
            padding-top: 17px;
            border-top: 1px solid #ece9e2;
        }

        .lux-home .lux-room-bottom strong {
            font-size: 18px;
            font-weight: 700;
        }

        .lux-home .lux-room-bottom small {
            color: var(--lux-muted);
            font-size: 11px;
            font-weight: 400;
        }

        .lux-home .lux-text-link {
            color: #8f682f;
            text-decoration: none;
            font-size: 12px;
            font-weight: 800;
        }

        .lux-home .lux-text-link:hover {
            text-decoration: underline;
        }

        .lux-home .lux-story-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            align-items: center;
            gap: clamp(30px, 6vw, 78px);
        }

        .lux-home .lux-story-image {
            position: relative;
            min-height: 450px;
        }

        .lux-home .lux-story-image img {
            position: absolute;
            inset: 0;
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .lux-home .lux-image-note {
            position: absolute;
            right: -18px;
            bottom: 24px;
            max-width: 220px;
            padding: 18px 20px;
            background: #fff;
            box-shadow: 0 12px 32px rgba(0, 0, 0, .12);
        }

        .lux-home .lux-image-note strong {
            display: block;
            margin-bottom: 4px;
            font: 500 20px Georgia, serif;
        }

        .lux-home .lux-image-note span {
            color: var(--lux-muted);
            font-size: 12px;
            line-height: 1.6;
        }

        .lux-home .lux-story-copy .lux-lead+.lux-lead {
            margin-top: 13px;
        }

        .lux-home .lux-story-points {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 18px;
            margin: 28px 0 30px;
            padding-top: 22px;
            border-top: 1px solid #e9e5dd;
        }

        .lux-home .lux-story-points strong {
            display: block;
            margin-bottom: 5px;
            font-size: 13px;
        }

        .lux-home .lux-story-points span {
            color: var(--lux-muted);
            font-size: 12px;
            line-height: 1.6;
        }

        .lux-home .lux-experience {
            background: #171a1c;
            color: #fff;
        }

        .lux-home .lux-experience .lux-heading {
            color: #fff;
        }

        .lux-home .lux-experience .lux-lead {
            color: #c4c7c8;
        }

        .lux-home .lux-experience-grid {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 0;
            margin-top: 42px;
            border-top: 1px solid rgba(255, 255, 255, .17);
        }

        .lux-home .lux-experience-item {
            padding: 26px 22px 0 0;
        }

        .lux-home .lux-experience-item+.lux-experience-item {
            padding-left: 22px;
            border-left: 1px solid rgba(255, 255, 255, .17);
        }

        .lux-home .lux-number {
            display: block;
            margin-bottom: 17px;
            color: #d0a35c;
            font: 500 28px Georgia, serif;
        }

        .lux-home .lux-experience-item h3 {
            margin: 0 0 9px;
            color: #fff;
            font-size: 15px;
            font-weight: 600;
        }

        .lux-home .lux-experience-item p {
            margin: 0;
            color: #b9bec1;
            font-size: 12px;
            line-height: 1.8;
        }

        .lux-home .lux-amenities {
            background: #fff;
        }

        .lux-home .lux-amenity-grid {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 14px;
        }

        .lux-home .lux-amenity {
            min-height: 190px;
            padding: 25px 22px;
            border: 1px solid #e9e5dd;
            background: #fff;
            transition: background .25s ease, border-color .25s ease, transform .25s ease;
        }

        .lux-home .lux-amenity:hover {
            background: #faf7f0;
            border-color: #d7bd91;
            transform: translateY(-3px);
        }

        .lux-home .lux-amenity-icon {
            display: grid;
            place-items: center;
            width: 43px;
            height: 43px;
            margin-bottom: 22px;
            border: 1px solid #e4d4b8;
            border-radius: 50%;
            color: #a57939;
            font-size: 17px;
        }

        .lux-home .lux-amenity h3 {
            margin: 0 0 8px;
            font: 500 20px Georgia, serif;
        }

        .lux-home .lux-amenity p {
            margin: 0;
            color: var(--lux-muted);
            font-size: 12px;
            line-height: 1.75;
        }

        .lux-home .lux-cta {
            padding: 0 0 88px;
        }

        .lux-home .lux-cta-panel {
            position: relative;
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 28px;
            min-height: 270px;
            padding: 50px 6%;
            overflow: hidden;
            background: #e9e2d6;
        }

        .lux-home .lux-cta-panel:after {
            content: "";
            position: absolute;
            top: 0;
            right: 0;
            width: 42%;
            height: 100%;
            background: linear-gradient(90deg, #e9e2d6 0%, rgba(233, 226, 214, .2) 35%, rgba(23, 26, 28, .12) 100%), url('https://images.unsplash.com/photo-1611892440504-42a792e24d32?w=1000') center/cover;
        }

        .lux-home .lux-cta-copy {
            position: relative;
            z-index: 1;
            max-width: 580px;
        }

        .lux-home .lux-cta-copy .lux-heading {
            font-size: clamp(30px, 3.5vw, 42px);
        }

        .lux-home .lux-cta-copy p {
            max-width: 520px;
            margin: 0 0 22px;
            color: #596067;
            font-size: 14px;
            line-height: 1.8;
        }

        .lux-home .lux-contact {
            padding: 72px 0;
            background: #f7f5f0;
        }

        .lux-home .lux-contact-grid {
            display: grid;
            grid-template-columns: 1.2fr 1fr 1fr 1fr;
            gap: 24px;
        }

        .lux-home .lux-contact-intro {
            padding-right: 16px;
        }

        .lux-home .lux-contact-intro h2 {
            margin: 10px 0;
            font: 500 30px/1.15 Georgia, serif;
        }

        .lux-home .lux-contact-intro p {
            color: var(--lux-muted);
            font-size: 12px;
            line-height: 1.8;
        }

        .lux-home .lux-contact-item {
            padding: 8px 0 0 20px;
            border-left: 1px solid #ddd5c8;
        }

        .lux-home .lux-contact-item span {
            display: block;
            margin-bottom: 12px;
            color: var(--lux-gold);
            font-size: 10px;
            font-weight: 800;
            letter-spacing: .16em;
            text-transform: uppercase;
        }

        .lux-home .lux-contact-item h3 {
            margin: 0 0 8px;
            font: 500 19px Georgia, serif;
        }

        .lux-home .lux-contact-item a,
        .lux-home .lux-contact-item p {
            margin: 0;
            color: var(--lux-muted);
            font-size: 12px;
            line-height: 1.8;
            overflow-wrap: anywhere;
            text-decoration: none;
        }

        .lux-home .lux-contact-item a:hover {
            color: #8f682f;
        }

        @media (max-width: 991.98px) {
            .lux-home .lux-room-card {
                flex-basis: 330px;
            }

            .lux-home .lux-room-photo,
            .lux-home .lux-room-card:first-child .lux-room-photo {
                height: 225px;
            }

            .lux-home .lux-experience-grid {
                grid-template-columns: repeat(2, 1fr);
            }

            .lux-home .lux-experience-item:nth-child(3) {
                padding-left: 0;
                border-left: 0;
            }

            .lux-home .lux-experience-item:nth-child(n+3) {
                margin-top: 25px;
            }

            .lux-home .lux-amenity-grid {
                grid-template-columns: repeat(2, 1fr);
            }

            .lux-home .lux-contact-grid {
                grid-template-columns: repeat(2, 1fr);
            }
        }

        @media (max-width: 767.98px) {
            .lux-home .lux-section {
                padding: 62px 0;
            }

            .lux-home .lux-wrap {
                width: min(100% - 30px, 560px);
            }

            .lux-home .lux-room-grid {
                gap: 14px;
                margin-right: -15px;
                padding-right: 15px;
            }

            .lux-home .lux-room-card {
                flex-basis: min(84vw, 340px);
            }

            .lux-home .lux-room-photo,
            .lux-home .lux-room-card:first-child .lux-room-photo {
                height: 220px;
            }

            .lux-home .lux-story-grid {
                grid-template-columns: 1fr;
            }

            .lux-home .lux-room-info p {
                min-height: 0;
            }

            .lux-home .lux-story-image {
                min-height: 320px;
                margin-right: 12px;
            }

            .lux-home .lux-image-note {
                right: -12px;
                bottom: 15px;
            }

            .lux-home .lux-story-points {
                gap: 12px;
            }

            .lux-home .lux-experience-grid {
                grid-template-columns: 1fr 1fr;
            }

            .lux-home .lux-experience-item,
            .lux-home .lux-experience-item+.lux-experience-item {
                padding: 20px 12px 0 0;
                border-left: 0;
            }

            .lux-home .lux-amenity-grid {
                grid-template-columns: 1fr 1fr;
                gap: 10px;
            }

            .lux-home .lux-amenity {
                min-height: 175px;
                padding: 18px 15px;
            }

            .lux-home .lux-amenity h3 {
                font-size: 17px;
            }

            .lux-home .lux-cta {
                padding-bottom: 62px;
            }

            .lux-home .lux-cta-panel {
                min-height: 0;
                padding: 35px 24px;
            }

            .lux-home .lux-cta-panel:after {
                width: 100%;
                opacity: .16;
            }

            .lux-home .lux-contact-grid {
                grid-template-columns: 1fr;
                gap: 24px;
            }

            .lux-home .lux-contact-item {
                padding-left: 15px;
            }
        }
    </style>

    <div class="lux-home">
        {{-- Featured rooms --}}

        {{-- HOTEL LUXURA: ORIGINAL DATABASE ROOMS --}}
        <!-- <div style="background:#fff3cd;padding:12px;margin:10px;">
                Rooms received by Blade: {{ isset($rooms) ? $rooms->count() : 'VARIABLE NOT PASSED' }}
            </div> -->
       
<style>
    /* ==============================
       HOTEL LUXURA — ROOM CAROUSEL
    ============================== */

    .lux-room-section {
        --lux-gold: #a17c43;
        --lux-ink: #24231f;
        --lux-muted: #77746e;
        position: relative;
        padding: 76px 0 70px;
        overflow: hidden;
        background: #faf9f6;
        color: var(--lux-ink);
    }

    .lux-room-heading {
        max-width: 1320px;
        margin: 0 auto 32px;
        padding: 0 28px;
        display: flex;
        align-items: end;
        justify-content: space-between;
        gap: 24px;
    }

    .lux-room-eyebrow {
        color: var(--lux-gold);
        font-size: 10px;
        font-weight: 700;
        letter-spacing: 3px;
        text-transform: uppercase;
    }

    .lux-room-heading h2 {
        margin: 12px 0;
        font-family: Georgia, serif;
        font-size: clamp(32px, 4vw, 49px);
        font-weight: 400;
        letter-spacing: -1.5px;
        line-height: 1.12;
    }

    .lux-room-heading h2 em {
        color: var(--lux-gold);
        font-weight: 400;
    }

    .lux-room-heading p {
        max-width: 520px;
        margin: 0;
        color: var(--lux-muted);
        font-size: 13px;
        line-height: 1.8;
    }

    .lux-room-controls {
        display: flex;
        gap: 10px;
        flex-shrink: 0;
    }

    .lux-room-arrow {
        display: grid;
        place-items: center;
        width: 46px;
        height: 46px;
        border: 1px solid #dedbd3;
        border-radius: 50%;
        background: transparent;
        color: var(--lux-ink);
        font-size: 22px;
        cursor: pointer;
        transition: background .25s, color .25s, border-color .25s;
    }

    .lux-room-arrow:hover {
        border-color: var(--lux-ink);
        background: var(--lux-ink);
        color: #fff;
    }

    /* Curved carousel viewport */
    .lux-room-viewport {
        position: relative;
        width: 100%;
        overflow: hidden;
        padding: 12px 0 30px;
        perspective: 1400px;
        perspective-origin: 50% 40%;
    }

    .lux-room-track {
        display: flex;
        align-items: stretch;
        gap: 22px;
        overflow-x: auto;
        overflow-y: hidden;
        padding: 8px max(28px, calc((100vw - 1264px) / 2)) 20px;
        scrollbar-width: none;
        scroll-snap-type: x mandatory;
        scroll-behavior: smooth;
        -webkit-overflow-scrolling: touch;
        transform-style: preserve-3d;
    }

    .lux-room-track::-webkit-scrollbar {
        display: none;
    }

    .lux-room-card {
        position: relative;
        display: flex;
        flex: 0 0 clamp(275px, 29vw, 350px);
        flex-direction: column;
        min-width: 0;
        overflow: hidden;
        border: 1px solid #ebe7df;
        border-radius: 25px;
        background: #fff;
        box-shadow: 0 7px 25px rgba(35, 31, 24, .035);
        scroll-snap-align: center;
        transform-origin: center center;
        backface-visibility: hidden;
        will-change: transform, opacity;
        transition:
            transform .38s ease,
            opacity .38s ease,
            box-shadow .38s ease;
    }

    .lux-room-card:hover {
        box-shadow: 0 16px 38px rgba(35, 31, 24, .10);
    }

    .lux-room-image {
        position: relative;
        display: block;
        height: 230px;
        flex-shrink: 0;
        overflow: hidden;
        background: #e9e3d8;
        color: #fff;
        text-decoration: none;
    }

    .lux-room-image img {
        display: block;
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: transform .65s ease;
    }

    .lux-room-card:hover .lux-room-image img {
        transform: scale(1.055);
    }

    .lux-room-image::after {
        position: absolute;
        inset: 45% 0 0;
        background: linear-gradient(transparent, rgba(0, 0, 0, .28));
        content: "";
        pointer-events: none;
    }

    .lux-room-view {
        position: absolute;
        z-index: 1;
        right: 14px;
        bottom: 14px;
        padding: 10px 15px;
        border: 1px solid rgba(255, 255, 255, .45);
        border-radius: 30px;
        background: rgba(28, 27, 24, .70);
        color: white;
        font-size: 11px;
        backdrop-filter: blur(9px);
        transition: background .2s;
    }

    .lux-room-image:hover .lux-room-view {
        background: var(--lux-gold);
    }

    .lux-room-no-image {
        display: flex;
        width: 100%;
        height: 100%;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        padding: 20px;
        background: linear-gradient(135deg, #38362f, #a17c43);
        color: white;
        text-align: center;
    }

    .lux-room-no-image span {
        font-size: 10px;
        letter-spacing: 3px;
    }

    .lux-room-no-image p {
        font-family: Georgia, serif;
        font-size: 25px;
    }

    .lux-room-info {
        display: flex;
        flex: 1;
        flex-direction: column;
        padding: 20px 20px 18px;
    }

    .lux-room-title-row {
        display: flex;
        align-items: start;
        justify-content: space-between;
        gap: 10px;
    }

    .lux-room-title-row h3 {
        margin: 0;
        font-family: Georgia, serif;
        font-size: 22px;
        font-weight: 400;
        line-height: 1.3;
        overflow-wrap: anywhere;
    }

    .lux-room-number {
        flex-shrink: 0;
        padding: 6px 9px;
        border-radius: 30px;
        background: #f4f1eb;
        color: #75654d;
        font-size: 10px;
        white-space: nowrap;
    }

    .lux-room-description {
        display: -webkit-box;
        min-height: 43px;
        margin: 11px 0 20px;
        overflow: hidden;
        color: var(--lux-muted);
        font-size: 12px;
        line-height: 1.8;
        -webkit-box-orient: vertical;
        -webkit-line-clamp: 2;
    }

    .lux-room-meta {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 12px;
        margin-top: auto;
        padding-top: 15px;
        border-top: 1px solid #efede8;
        color: var(--lux-muted);
        font-size: 11px;
    }

    .lux-room-capacity {
        white-space: nowrap;
    }

    .lux-room-price {
        color: var(--lux-ink);
        font-size: 19px;
        font-weight: 650;
        white-space: nowrap;
    }

    .lux-room-price small {
        color: #858178;
        font-size: 10px;
        font-weight: 400;
    }

    /* Draggable slider under the cards */
    .lux-room-scroll-control {
        display: flex;
        align-items: center;
        gap: 17px;
        max-width: 1320px;
        margin: 0 auto;
        padding: 0 28px;
    }

    .lux-room-scroll-label {
        flex-shrink: 0;
        color: #8b8579;
        font-size: 10px;
        letter-spacing: 1.8px;
        text-transform: uppercase;
    }

    .lux-room-range {
        --lux-progress: 0%;
        display: block;
        width: 100%;
        height: 3px;
        margin: 0;
        appearance: none;
        -webkit-appearance: none;
        border: 0;
        border-radius: 10px;
        outline: none;
        cursor: grab;
        background: linear-gradient(
            to right,
            var(--lux-gold) 0%,
            var(--lux-gold) var(--lux-progress),
            #ded9cf var(--lux-progress),
            #ded9cf 100%
        );
    }

    .lux-room-range:active {
        cursor: grabbing;
    }

    .lux-room-range::-webkit-slider-thumb {
        width: 17px;
        height: 17px;
        appearance: none;
        -webkit-appearance: none;
        border: 4px solid #faf9f6;
        border-radius: 50%;
        background: var(--lux-gold);
        box-shadow: 0 0 0 1px var(--lux-gold);
    }

    .lux-room-range::-moz-range-thumb {
        width: 10px;
        height: 10px;
        border: 3px solid #faf9f6;
        border-radius: 50%;
        background: var(--lux-gold);
        box-shadow: 0 0 0 1px var(--lux-gold);
    }

    .lux-room-scroll-count {
        min-width: 48px;
        color: var(--lux-muted);
        font-size: 11px;
        text-align: right;
        white-space: nowrap;
    }

    .lux-room-empty {
        margin: 0 28px;
        padding: 48px 24px;
        border: 1px solid #eae5dc;
        border-radius: 25px;
        background: #fff;
        text-align: center;
    }

    .lux-room-empty h3 {
        margin: 0 0 10px;
        font-family: Georgia, serif;
        font-size: 27px;
        font-weight: 400;
    }

    .lux-room-empty p {
        margin: 0;
        color: var(--lux-muted);
        font-size: 13px;
    }

    @media (max-width: 760px) {
        .lux-room-section {
            padding: 50px 0 48px;
        }

        .lux-room-heading {
            align-items: end;
            padding: 0 18px;
            gap: 12px;
        }

        .lux-room-heading h2 {
            font-size: 31px;
            letter-spacing: -.8px;
        }

        .lux-room-heading p {
            font-size: 12px;
        }

        .lux-room-controls {
            gap: 6px;
        }

        .lux-room-arrow {
            width: 35px;
            height: 35px;
            font-size: 18px;
        }

        .lux-room-track {
            gap: 15px;
            padding-right: 18px;
            padding-left: 18px;
        }

        .lux-room-card {
            flex-basis: 80vw;
            max-width: 350px;
        }

        .lux-room-image {
            height: 215px;
        }

        .lux-room-info {
            padding: 18px;
        }

        .lux-room-scroll-control {
            gap: 10px;
            padding: 0 18px;
        }

        .lux-room-scroll-label {
            font-size: 9px;
            letter-spacing: 1px;
        }

        .lux-room-empty {
            margin: 0 18px;
        }
    }

    @media (prefers-reduced-motion: reduce) {
        .lux-room-track {
            scroll-behavior: auto;
        }

        .lux-room-card,
        .lux-room-image img {
            transition: none;
        }
    }
</style>

<section class="lux-room-section" data-lux-room-carousel>
    <div class="lux-room-heading">
        <div>
            <div class="lux-room-eyebrow">Stay your way</div>
            <h2>Rooms made for <em>your comfort.</em></h2>
            <p>Thoughtfully designed spaces, refined details, and a stay worth remembering.</p>
        </div>

        <div class="lux-room-controls">
            <button class="lux-room-arrow" type="button"
                data-lux-prev aria-label="Previous rooms">←</button>
            <button class="lux-room-arrow" type="button"
                data-lux-next aria-label="Next rooms">→</button>
        </div>
    </div>

    @if (isset($rooms) && $rooms->isNotEmpty())
        <div class="lux-room-viewport">
            <div class="lux-room-track" data-lux-track>
                @foreach ($rooms as $room)
                    @php
                        $type = $room->roomType;
                        $photo = $type?->room_photo_url;
                        $roomName = $type?->name ?? 'Guest Room';
                        $roomNumber = $room->room_number ?? $room->id;
                        $capacity = $type?->capacity ?? 1;
                        $price = $type?->price;
                        $description = $type?->description;
                    @endphp

                    @continue(!$type)

                    <article class="lux-room-card" data-lux-card>
                        <a class="lux-room-image"
                           href="{{ route('frontend.room.show', ['room' => $room->id]) }}"
                           aria-label="View {{ $roomName }}">
                            @if ($photo)
                                <img
                                    src="{{ $photo }}"
                                    alt="{{ $roomName }}"
                                    loading="lazy"
                                    onerror="this.style.display='none';this.nextElementSibling.hidden=false;"
                                >
                                <div class="lux-room-no-image" hidden>
                                    <span>HOTEL LUXURA</span>
                                    <p>{{ $roomName }}</p>
                                </div>
                            @else
                                <div class="lux-room-no-image">
                                    <span>HOTEL LUXURA</span>
                                    <p>{{ $roomName }}</p>
                                </div>
                            @endif

                            <span class="lux-room-view">View room ↗</span>
                        </a>

                        <div class="lux-room-info">
                            <div class="lux-room-title-row">
                                <h3>{{ $roomName }}</h3>
                                <span class="lux-room-number">
                                    Room {{ $roomNumber }}
                                </span>
                            </div>

                            <p class="lux-room-description">
                                {{ \Illuminate\Support\Str::limit(
                                    trim(strip_tags($description ?? 'A comfortable stay with thoughtful details.')),
                                    115
                                ) }}
                            </p>

                            <div class="lux-room-meta">
                                <span class="lux-room-capacity">
                                    ♙ {{ $capacity }}
                                    {{ (int) $capacity === 1 ? 'Guest' : 'Guests' }}
                                </span>

                                <span class="lux-room-price">
                                    @if ($price !== null)
                                        ₹{{ number_format((float) $price) }}
                                    @else
                                        Contact us
                                    @endif
                                    <small>/ night</small>
                                </span>
                            </div>
                        </div>
                    </article>
                @endforeach
            </div>
        </div>

        <div class="lux-room-scroll-control">
            <span class="lux-room-scroll-label">Explore rooms</span>

            <input
                type="range"
                class="lux-room-range"
                data-lux-range
                min="0"
                max="1000"
                value="0"
                step="1"
                aria-label="Scroll through hotel rooms"
            >

            <span class="lux-room-scroll-count" data-lux-count>
                01 / {{ sprintf('%02d', $rooms->count()) }}
            </span>
        </div>
    @else
        <div class="lux-room-empty">
            <h3>Your next stay starts here.</h3>
            <p>No rooms are currently available to display.</p>
        </div>
    @endif
</section>

<script>
(function () {
    function initLuxRoomCarousels() {
        document.querySelectorAll('[data-lux-room-carousel]').forEach(function (section) {
            if (section.dataset.luxInitialized === 'true') return;

            const track = section.querySelector('[data-lux-track]');
            const cards = Array.from(section.querySelectorAll('[data-lux-card]'));
            const range = section.querySelector('[data-lux-range]');
            const count = section.querySelector('[data-lux-count]');
            const prev = section.querySelector('[data-lux-prev]');
            const next = section.querySelector('[data-lux-next]');

            if (!track || !cards.length || !range) return;

            section.dataset.luxInitialized = 'true';

            let framePending = false;

            function clamp(value, min, max) {
                return Math.max(min, Math.min(max, value));
            }

            function getMetrics() {
                const maxScroll = Math.max(0, track.scrollWidth - track.clientWidth);
                const trackRect = track.getBoundingClientRect();
                const center = trackRect.left + trackRect.width / 2;
                return { maxScroll, center, trackRect };
            }

            function updateCarousel() {
                framePending = false;

                const metrics = getMetrics();
                const maxScroll = metrics.maxScroll;
                const center = metrics.center;
                const width = Math.max(metrics.trackRect.width / 2, 1);

                let activeIndex = 0;
                let nearestDistance = Infinity;

                cards.forEach(function (card, index) {
                    const rect = card.getBoundingClientRect();
                    const cardCenter = rect.left + rect.width / 2;
                    const offset = (cardCenter - center) / width;
                    const curve = clamp(offset, -1.35, 1.35);
                    const abs = Math.min(Math.abs(curve), 1);

                    // Smooth curved, perspective-like room movement.
                    const rotateY = -curve * 15;
                    const translateY = abs * 20;
                    const scale = 1 - abs * 0.075;
                    const opacity = 1 - abs * 0.22;

                    card.style.transform =
                        'rotateY(' + rotateY + 'deg) ' +
                        'translateY(' + translateY + 'px) ' +
                        'scale(' + scale + ')';

                    card.style.opacity = String(opacity);

                    const distance = Math.abs(cardCenter - center);
                    if (distance < nearestDistance) {
                        nearestDistance = distance;
                        activeIndex = index;
                    }
                });

                const progress = maxScroll > 0 ? track.scrollLeft / maxScroll : 0;
                range.value = String(Math.round(progress * 1000));
                range.style.setProperty('--lux-progress', (progress * 100) + '%');

                if (count) {
                    count.textContent =
                        String(activeIndex + 1).padStart(2, '0') +
                        ' / ' +
                        String(cards.length).padStart(2, '0');
                }

                if (prev) prev.disabled = track.scrollLeft <= 2;
                if (next) next.disabled = track.scrollLeft >= maxScroll - 2;
            }

            function requestUpdate() {
                if (framePending) return;
                framePending = true;
                requestAnimationFrame(updateCarousel);
            }

            function scrollOne(direction) {
                const metrics = getMetrics();
                const currentCenter = metrics.center;

                let closestCard = cards[0];
                let closestDistance = Infinity;

                cards.forEach(function (card) {
                    const rect = card.getBoundingClientRect();
                    const distance = Math.abs(rect.left + rect.width / 2 - currentCenter);

                    if (distance < closestDistance) {
                        closestDistance = distance;
                        closestCard = card;
                    }
                });

                const currentIndex = cards.indexOf(closestCard);
                const targetIndex = clamp(currentIndex + direction, 0, cards.length - 1);
                const target = cards[targetIndex];

                const trackRect = track.getBoundingClientRect();
                const cardRect = target.getBoundingClientRect();
                const delta =
                    (cardRect.left + cardRect.width / 2) -
                    (trackRect.left + trackRect.width / 2);

                track.scrollTo({
                    left: track.scrollLeft + delta,
                    behavior: 'smooth'
                });
            }

            if (prev) prev.addEventListener('click', function () {
                scrollOne(-1);
            });

            if (next) next.addEventListener('click', function () {
                scrollOne(1);
            });

            range.addEventListener('input', function () {
                const maxScroll = Math.max(0, track.scrollWidth - track.clientWidth);
                track.scrollLeft = (Number(range.value) / 1000) * maxScroll;
                requestUpdate();
            });

            track.addEventListener('scroll', requestUpdate, { passive: true });
            window.addEventListener('resize', requestUpdate);

            // Optional mouse wheel support for desktop.
            track.addEventListener('wheel', function (event) {
                if (Math.abs(event.deltaY) > Math.abs(event.deltaX)) {
                    track.scrollLeft += event.deltaY;
                }
            }, { passive: true });

            updateCarousel();
        });
    }

    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', initLuxRoomCarousels);
    } else {
        initLuxRoomCarousels();
    }
})();
</script>


        {{-- Hotel story: a different visual rhythm from room cards --}}
        <section class="lux-section">
            <div class="lux-wrap lux-story-grid">
                <div class="lux-story-image">
                    <img src="https://images.unsplash.com/photo-1600210492486-724fe5c67fb0?w=1100&q=85"
                        alt="Warm, refined hotel interior" loading="lazy">
                    <div class="lux-image-note"><strong>Thoughtful by design.</strong><span>Considered details. A calmer
                            pace. A stay that feels personal.</span></div>
                </div>
                <div class="lux-story-copy">
                    <span class="lux-kicker">The Luxura feeling</span>
                    <h2 class="lux-heading">Luxury is how<br>the stay makes you feel.</h2>
                    <p class="lux-lead">At Hotel Luxura, we believe hospitality is found in the details — a welcoming
                        arrival, a restful room and support that feels natural rather than formal.</p>
                    <p class="lux-lead">Whether you are travelling for business, taking a break or celebrating a special
                        moment, our aim is simple: make your time away comfortable, considered and easy.</p>
                    <div class="lux-story-points">
                        <div><strong><i class="fas fa-check" style="color:#b78a45;margin-right:7px"></i>Considered
                                comfort</strong><span>Spaces designed to help you settle in and switch off.</span></div>
                        <div><strong><i class="fas fa-check" style="color:#b78a45;margin-right:7px"></i>Warm
                                hospitality</strong><span>Helpful service, from arrival to departure.</span></div>
                    </div>
                    <a href="{{ route('frontend.amenities.index') }}" class="lux-btn">Explore our facilities <i
                            class="fas fa-arrow-right"></i></a>
                </div>
            </div>
        </section>

        {{-- Service values instead of another row of generic cards --}}
        <section class="lux-section lux-experience">
            <div class="lux-wrap">
                <div class="lux-section-head">
                    <span class="lux-kicker">The Luxura difference</span>
                    <h2 class="lux-heading">The little things make<br>the whole experience.</h2>
                    <p class="lux-lead">A great stay is more than a beautiful room. It is the ease, care and peace of mind
                        that comes with it.</p>
                </div>
                <div class="lux-experience-grid">
                    <div class="lux-experience-item"><span class="lux-number">01</span>
                        <h3>Comfort, thoughtfully considered</h3>
                        <p>Relax in welcoming spaces with the essentials you need to feel at home.</p>
                    </div>
                    <div class="lux-experience-item"><span class="lux-number">02</span>
                        <h3>Service with a personal touch</h3>
                        <p>Our team is here to make your stay smoother and help when you need it.</p>
                    </div>
                    <div class="lux-experience-item"><span class="lux-number">03</span>
                        <h3>Confidence from check-in</h3>
                        <p>A clear booking journey and attentive support help you travel with confidence.</p>
                    </div>
                    <div class="lux-experience-item"><span class="lux-number">04</span>
                        <h3>Made for your kind of trip</h3>
                        <p>A comfortable base for business trips, weekend escapes and special occasions.</p>
                    </div>
                </div>
            </div>
        </section>

        {{-- Amenities: compact editorial grid, not repeated image cards --}}
        <section class="lux-section lux-amenities">
            <div class="lux-wrap">
                <div class="lux-section-head center">
                    <span class="lux-kicker">More to enjoy</span>
                    <h2 class="lux-heading">Everything in its right place.</h2>
                    <p class="lux-lead">From moments of relaxation to the everyday essentials, explore the facilities
                        designed to make your visit feel effortless.</p>
                </div>
                <div class="lux-amenity-grid">
                    <article class="lux-amenity">
                        <div class="lux-amenity-icon"><i class="fas fa-swimming-pool"></i></div>
                        <h3>Pool & relaxation</h3>
                        <p>Take a pause, unwind and make a little time for yourself.</p>
                    </article>
                    <article class="lux-amenity">
                        <div class="lux-amenity-icon"><i class="fas fa-utensils"></i></div>
                        <h3>Dining</h3>
                        <p>Enjoy a relaxed meal and discover flavours to suit your mood.</p>
                    </article>
                    <article class="lux-amenity">
                        <div class="lux-amenity-icon"><i class="fas fa-spa"></i></div>
                        <h3>Wellness</h3>
                        <p>Make space in your itinerary to slow down and recharge.</p>
                    </article>
                    <article class="lux-amenity">
                        <div class="lux-amenity-icon"><i class="fas fa-concierge-bell"></i></div>
                        <h3>Guest assistance</h3>
                        <p>Friendly support to help with questions and stay arrangements.</p>
                    </article>
                </div>
                <div class="text-center mt-4"><a href="{{ route('frontend.amenities.index') }}" class="lux-text-link">View
                        all facilities <i class="fas fa-arrow-right"></i></a></div>
            </div>
        </section>

        {{-- Strong booking CTA --}}
        <section class="lux-cta">
            <div class="lux-wrap">
                <div class="lux-cta-panel">
                    <div class="lux-cta-copy">
                        <span class="lux-kicker">Your next stay starts here</span>
                        <h2 class="lux-heading">Make room for<br>something memorable.</h2>
                        <p>Choose your dates, find a room that fits your plans and look forward to a more comfortable stay
                            at Hotel Luxura.</p>
                        <a href="{{ route('frontend.room.index') }}" class="lux-btn">Explore available rooms <i
                                class="fas fa-arrow-right"></i></a>
                    </div>
                </div>
            </div>
        </section>

        {{-- Guest support --}}
        <section class="lux-contact">
            <div class="lux-wrap lux-contact-grid">
                <div class="lux-contact-intro">
                    <span class="lux-kicker">We're here to help</span>
                    <h2>A smoother stay<br>starts with a hello.</h2>
                    <p>Need help with a booking or have a question before you arrive? Reach out to our guest support team.
                    </p>
                </div>
                <div class="lux-contact-item"><span>Call our team</span>
                    <h3>Phone</h3><a href="tel:+919316449257">+91 9316449257</a>
                </div>
                <div class="lux-contact-item"><span>Write to us</span>
                    <h3>Email</h3><a href="mailto:haidarmaknojiya1306@gmail.com">haidarmaknojiya1306@gmail.com</a>
                </div>
                <div class="lux-contact-item"><span>Find us</span>
                    <h3>Location</h3>
                    <p>Palanpur, Gujarat, India</p>
                </div>
            </div>
        </section>
    </div>

@endsection