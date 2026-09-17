@extends('frontend.layouts.app')

@section('title', $room->roomType->name . ' | Room Details')

@push('after-styles')
<style>
    :root {
        --room-dark: #25211d;
        --room-text: #514a42;
        --room-muted: #918678;
        --room-gold: #c29a3a;
        --room-gold-dark: #9f7925;
        --room-cream: #f8f5ef;
        --room-white: #fffdf9;
        --room-border: #e8e0d3;
    }

    /* =========================================
       ROOM PAGE
    ========================================= */

    .room-page {
        background: #fffdf9;
        color: var(--room-dark);
    }

    /* =========================================
       MODERN EDITORIAL HERO
    ========================================= */

    .room-hero-modern {
        position: relative;
        overflow: hidden;
        min-height: 540px;
        background:
            radial-gradient(circle at 82% 20%, rgba(194,154,58,.12), transparent 28%),
            radial-gradient(circle at 10% 90%, rgba(194,154,58,.07), transparent 30%),
            #f4f0e8;
        border-bottom: 1px solid var(--room-border);
        display: flex;
        align-items: center;
    }

    .room-hero-modern::before {
        content: "";
        position: absolute;
        width: 430px;
        height: 430px;
        border: 1px solid rgba(194,154,58,.25);
        border-radius: 50%;
        right: -120px;
        top: -120px;
    }

    .room-hero-modern::after {
        content: "";
        position: absolute;
        width: 260px;
        height: 260px;
        border: 1px solid rgba(37,33,29,.08);
        border-radius: 50%;
        right: 80px;
        bottom: -150px;
    }

    .room-hero-inner {
        width: min(1180px, calc(100% - 48px));
        margin: 0 auto;
        position: relative;
        z-index: 2;
        padding: 90px 0;
        display: grid;
        grid-template-columns: 1.5fr .7fr;
        gap: 70px;
        align-items: center;
    }

    .room-hero-content {
        max-width: 720px;
    }

    .room-kicker {
        display: flex;
        align-items: center;
        gap: 14px;
        margin-bottom: 24px;
        font-family: 'Jost', sans-serif;
        font-size: 11px;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 3px;
        color: var(--room-gold-dark);
    }

    .room-kicker::before {
        content: "";
        width: 42px;
        height: 1px;
        background: var(--room-gold);
    }

    .room-hero-number {
        font-family: 'Playfair Display', serif;
        font-size: clamp(100px, 14vw, 180px);
        line-height: .75;
        font-weight: 400;
        color: rgba(37,33,29,.055);
        position: absolute;
        left: -15px;
        top: 50%;
        transform: translateY(-50%);
        z-index: -1;
        pointer-events: none;
    }

    .room-hero-title {
        font-family: 'Playfair Display', serif;
        font-size: clamp(48px, 6vw, 78px);
        line-height: 1.02;
        font-weight: 500;
        letter-spacing: -1.8px;
        color: var(--room-dark);
        margin: 0 0 25px;
        max-width: 760px;
    }

    .room-hero-description {
        max-width: 650px;
        font-family: 'Jost', sans-serif;
        font-size: 16px;
        line-height: 1.9;
        color: var(--room-text);
        margin: 0;
    }

    .room-hero-meta {
        display: flex;
        align-items: center;
        gap: 12px;
        margin-top: 32px;
        flex-wrap: wrap;
    }

    .room-status {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        padding: 9px 15px;
        border-radius: 30px;
        background: #eaf4e8;
        color: #477044;
        font-family: 'Jost', sans-serif;
        font-size: 11px;
        font-weight: 600;
        letter-spacing: .8px;
        text-transform: uppercase;
    }

    .room-status::before {
        content: "";
        width: 6px;
        height: 6px;
        background: #5e9957;
        border-radius: 50%;
    }

    .room-status.unavailable {
        background: #f5e4dd;
        color: #a34e32;
    }

    .room-status.unavailable::before {
        background: #b3532b;
    }

    .room-number-pill {
        display: inline-flex;
        align-items: center;
        padding: 9px 15px;
        border: 1px solid var(--room-border);
        border-radius: 30px;
        font-family: 'Jost', sans-serif;
        font-size: 11px;
        color: var(--room-text);
        text-transform: uppercase;
        letter-spacing: 1px;
        background: rgba(255,255,255,.55);
    }

    /* Hero side visual */

    .room-hero-side {
        display: flex;
        justify-content: center;
        align-items: center;
    }

    .room-hero-emblem {
        width: 260px;
        height: 260px;
        border: 1px solid rgba(194,154,58,.45);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        position: relative;
    }

    .room-hero-emblem::before {
        content: "";
        position: absolute;
        inset: 18px;
        border: 1px solid rgba(194,154,58,.25);
        border-radius: 50%;
    }

    .room-hero-emblem::after {
        content: "";
        position: absolute;
        width: 8px;
        height: 8px;
        background: var(--room-gold);
        border-radius: 50%;
        top: 16px;
        left: 50%;
        transform: translateX(-50%);
    }

    .room-emblem-inner {
        text-align: center;
        position: relative;
        z-index: 2;
    }

    .room-emblem-inner small {
        display: block;
        font-family: 'Jost', sans-serif;
        text-transform: uppercase;
        letter-spacing: 3px;
        font-size: 10px;
        color: var(--room-muted);
        margin-bottom: 8px;
    }

    .room-emblem-inner strong {
        display: block;
        font-family: 'Playfair Display', serif;
        font-size: 64px;
        font-weight: 400;
        line-height: 1;
        color: var(--room-dark);
    }

    .room-emblem-inner span {
        display: block;
        margin-top: 12px;
        font-family: 'Jost', sans-serif;
        font-size: 10px;
        letter-spacing: 2px;
        text-transform: uppercase;
        color: var(--room-gold-dark);
    }

    /* =========================================
       QUICK FACTS
    ========================================= */

    .room-facts-bar {
        background: var(--room-dark);
        color: #fff;
    }

    .room-facts-inner {
        width: min(1180px, calc(100% - 48px));
        margin: auto;
        display: grid;
        grid-template-columns: repeat(4, 1fr);
    }

    .room-fact {
        padding: 25px 30px;
        border-right: 1px solid rgba(255,255,255,.09);
        display: flex;
        align-items: center;
        gap: 14px;
    }

    .room-fact:first-child {
        padding-left: 0;
    }

    .room-fact:last-child {
        border-right: 0;
    }

    .room-fact-icon {
        width: 38px;
        height: 38px;
        border: 1px solid rgba(194,154,58,.4);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        color: var(--room-gold);
        flex-shrink: 0;
    }

    .room-fact small {
        display: block;
        font-family: 'Jost', sans-serif;
        color: rgba(255,255,255,.5);
        font-size: 9px;
        text-transform: uppercase;
        letter-spacing: 1.5px;
        margin-bottom: 3px;
    }

    .room-fact strong {
        font-family: 'Jost', sans-serif;
        font-size: 14px;
        font-weight: 500;
        color: #fff;
    }

    /* =========================================
       MAIN DETAIL AREA
    ========================================= */

    .room-detail-wrap {
        width: min(1180px, calc(100% - 48px));
        margin: 0 auto;
        padding: 90px 0 110px;
    }

    .room-detail-grid {
        display: grid;
        grid-template-columns: minmax(0, 1.55fr) minmax(320px, .75fr);
        gap: 85px;
        align-items: start;
    }

    .room-section-label {
        font-family: 'Jost', sans-serif;
        font-size: 10px;
        text-transform: uppercase;
        letter-spacing: 2.5px;
        color: var(--room-gold-dark);
        font-weight: 600;
        display: flex;
        align-items: center;
        gap: 12px;
        margin-bottom: 15px;
    }

    .room-section-label::before {
        content: "";
        width: 28px;
        height: 1px;
        background: var(--room-gold);
    }

    .room-main-heading {
        font-family: 'Playfair Display', serif;
        font-size: 36px;
        font-weight: 500;
        line-height: 1.2;
        color: var(--room-dark);
        margin: 0 0 24px;
    }

    .room-detail-desc {
        font-family: 'Jost', sans-serif;
        font-size: 16px;
        line-height: 2;
        color: var(--room-text);
        margin: 0 0 45px;
        max-width: 720px;
    }

    /* =========================================
       AMENITIES
    ========================================= */

    .room-amenities-section {
        padding-top: 40px;
        border-top: 1px solid var(--room-border);
    }

    .room-amenities-heading {
        font-family: 'Playfair Display', serif;
        font-size: 28px;
        font-weight: 500;
        color: var(--room-dark);
        margin: 0 0 25px;
    }

    .room-amenity-grid {
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        gap: 0;
        border-top: 1px solid var(--room-border);
        border-left: 1px solid var(--room-border);
    }

    .room-amenity-item {
        min-height: 62px;
        display: flex;
        align-items: center;
        gap: 14px;
        padding: 15px 18px;
        border-right: 1px solid var(--room-border);
        border-bottom: 1px solid var(--room-border);
        font-family: 'Jost', sans-serif;
        font-size: 13px;
        color: var(--room-text);
        background: #fff;
    }

    .room-amenity-item i {
        color: var(--room-gold);
        font-size: 13px;
        width: 20px;
        text-align: center;
    }

    /* =========================================
       BOOKING CARD
    ========================================= */

    .room-booking-card {
        position: sticky;
        top: 100px;
        background: var(--room-white);
        border: 1px solid var(--room-border);
        box-shadow: 0 20px 55px rgba(37,33,29,.08);
        padding: 36px;
    }

    .booking-card-top {
        display: flex;
        justify-content: space-between;
        align-items: flex-start;
        gap: 15px;
        margin-bottom: 25px;
    }

    .booking-card-label {
        font-family: 'Jost', sans-serif;
        font-size: 10px;
        text-transform: uppercase;
        letter-spacing: 2px;
        color: var(--room-muted);
    }

    .room-booking-price {
        font-family: 'Playfair Display', serif;
        font-size: 38px;
        font-weight: 500;
        color: var(--room-dark);
        line-height: 1;
        margin-top: 8px;
    }

    .room-booking-price small {
        font-family: 'Jost', sans-serif;
        font-size: 11px;
        color: var(--room-muted);
        letter-spacing: .5px;
    }

    .booking-divider {
        height: 1px;
        background: var(--room-border);
        margin: 28px 0;
    }

    .booking-info-row {
        display: flex;
        justify-content: space-between;
        gap: 20px;
        padding: 12px 0;
        border-bottom: 1px solid #f0ebe3;
        font-family: 'Jost', sans-serif;
        font-size: 13px;
    }

    .booking-info-row:last-of-type {
        border-bottom: 0;
    }

    .booking-info-row span:first-child {
        color: var(--room-muted);
    }

    .booking-info-row span:last-child {
        color: var(--room-dark);
        font-weight: 500;
        text-align: right;
    }

    .room-book-btn-full {
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 10px;
        width: 100%;
        padding: 16px 20px;
        background: var(--room-dark);
        color: #fff;
        text-decoration: none;
        font-family: 'Jost', sans-serif;
        font-size: 12px;
        font-weight: 600;
        letter-spacing: 1px;
        text-transform: uppercase;
        margin-top: 28px;
        border: 1px solid var(--room-dark);
        transition: all .25s ease;
    }

    .room-book-btn-full:hover {
        background: var(--room-gold);
        border-color: var(--room-gold);
        color: #fff;
        transform: translateY(-2px);
    }

    .room-book-btn-full.is-disabled {
        background: #eee9e0;
        color: #9c9387;
        border-color: #eee9e0;
        cursor: not-allowed;
    }

    .booking-note {
        text-align: center;
        margin: 17px 0 0;
        font-family: 'Jost', sans-serif;
        font-size: 10px;
        color: var(--room-muted);
    }

    /* =========================================
       EXPERIENCE STRIP
    ========================================= */

    .room-experience {
        background: var(--room-cream);
        padding: 80px 24px;
        text-align: center;
        border-top: 1px solid var(--room-border);
    }

    .room-experience-inner {
        max-width: 760px;
        margin: auto;
    }

    .room-experience h2 {
        font-family: 'Playfair Display', serif;
        font-size: 38px;
        font-weight: 500;
        color: var(--room-dark);
        margin: 0 0 18px;
    }

    .room-experience p {
        font-family: 'Jost', sans-serif;
        color: var(--room-text);
        line-height: 1.9;
        margin: 0;
        font-size: 15px;
    }

    /* =========================================
       RESPONSIVE
    ========================================= */

    @media (max-width: 900px) {
        .room-hero-inner {
            grid-template-columns: 1fr;
            gap: 35px;
            padding: 75px 0;
        }

        .room-hero-side {
            justify-content: flex-start;
        }

        .room-hero-emblem {
            width: 170px;
            height: 170px;
        }

        .room-emblem-inner strong {
            font-size: 42px;
        }

        .room-facts-inner {
            grid-template-columns: repeat(2, 1fr);
        }

        .room-fact:nth-child(2) {
            border-right: 0;
        }

        .room-fact:first-child {
            padding-left: 20px;
        }

        .room-detail-grid {
            grid-template-columns: 1fr;
            gap: 55px;
        }

        .room-booking-card {
            position: relative;
            top: auto;
        }
    }

    @media (max-width: 600px) {
        .room-hero-inner,
        .room-detail-wrap,
        .room-facts-inner {
            width: min(100% - 32px, 1180px);
        }

        .room-hero-inner {
            padding: 65px 0;
        }

        .room-hero-title {
            font-size: 45px;
            letter-spacing: -1px;
        }

        .room-hero-description {
            font-size: 14px;
            line-height: 1.8;
        }

        .room-facts-inner {
            grid-template-columns: 1fr 1fr;
        }

        .room-fact {
            padding: 20px 8px;
            gap: 8px;
        }

        .room-fact:first-child {
            padding-left: 0;
        }

        .room-fact-icon {
            width: 32px;
            height: 32px;
        }

        .room-fact strong {
            font-size: 12px;
        }

        .room-detail-wrap {
            padding: 65px 0 80px;
        }

        .room-main-heading {
            font-size: 30px;
        }

        .room-amenity-grid {
            grid-template-columns: 1fr;
        }

        .room-booking-card {
            padding: 27px 22px;
        }

        .room-experience h2 {
            font-size: 30px;
        }
    }
    /* =========================================
   FULL WIDTH ROOM IMAGE
========================================= */

.room-image-section {
    width: 100%;
    margin: 0;
    padding: 0;
    overflow: hidden;
}

.room-image-frame {
    width: 100%;
    height: 600px;
    overflow: hidden;
    margin: 0;
    padding: 0;
    border: none;
    box-shadow: none;
    background: var(--room-cream);
}

.room-image-frame img {
    display: block;
    width: 100% !important;
    height: 100% !important;
    max-width: none !important;
    object-fit: cover;
    object-position: center;
    margin: 0;
    padding: 0;
}
/* =========================================
   ROOM SHOW — NAVBAR ONLY
   ========================================= */

/* ---------- TOP / TRANSPARENT NAVBAR ---------- */

body:has(.room-page) .hotel-navbar:not(.scrolled) .navbar-brand {
    color: #25211d !important;
}

body:has(.room-page) .hotel-navbar:not(.scrolled) .navbar-brand span,
body:has(.room-page) .hotel-navbar:not(.scrolled) .navbar-brand strong {
    color: #25211d !important;
}

body:has(.room-page) .hotel-navbar:not(.scrolled) .nav-link {
    color: #25211d !important;
}

body:has(.room-page) .hotel-navbar:not(.scrolled) .dropdown-toggle {
    color: #25211d !important;
}

body:has(.room-page) .hotel-navbar:not(.scrolled) i {
    color: #25211d !important;
}

/* TOP — ACTIVE ROOMS */
body:has(.room-page) .hotel-navbar:not(.scrolled) .nav-link.active {
    color: #c29a3a !important;
}

body:has(.room-page) .hotel-navbar:not(.scrolled) .nav-link.active::after {
    background: #c29a3a !important;
}


/* ---------- SCROLLED NAVBAR ---------- */

body:has(.room-page) .hotel-navbar.scrolled .navbar-brand {
    color: #fffdf9 !important;
}

body:has(.room-page) .hotel-navbar.scrolled .navbar-brand span,
body:has(.room-page) .hotel-navbar.scrolled .navbar-brand strong {
    color: #fffdf9 !important;
}

body:has(.room-page) .hotel-navbar.scrolled .nav-link {
    color: #fffdf9 !important;
}

body:has(.room-page) .hotel-navbar.scrolled .dropdown-toggle {
    color: #fffdf9 !important;
}

body:has(.room-page) .hotel-navbar.scrolled i {
    color: #fffdf9 !important;
}

/* SCROLLED — ACTIVE ROOMS */
body:has(.room-page) .hotel-navbar.scrolled .nav-link.active {
    color: #c29a3a !important;
}

body:has(.room-page) .hotel-navbar.scrolled .nav-link.active::after {
    background: #c29a3a !important;
}
</style>
@endpush


@section('content')

<div class="room-page">

    {{-- =========================================
         MODERN ROOM HERO — NO IMAGE
    ========================================== --}}

    <section class="room-hero-modern">

        <div class="room-hero-inner">

            <div class="room-hero-content">

                <span class="room-hero-number">
                    {{ $room->room_number }}
                </span>

                <div class="room-kicker">
                    Private Stay · Room {{ $room->room_number }}
                </div>

                <h1 class="room-hero-title">
                    {{ $room->roomType->name }}
                </h1>

                <p class="room-hero-description">
                    {{ $room->roomType->description ?? 'A thoughtfully designed room offering comfort, elegance and a memorable stay experience.' }}
                </p>

                <div class="room-hero-meta">

                    @if($room->status)
                        <span class="room-status">
                            Available
                        </span>
                    @else
                        <span class="room-status unavailable">
                            Not Available
                        </span>
                    @endif

                    <span class="room-number-pill">
                        Room {{ $room->room_number }}
                    </span>

                </div>

            </div>


            {{-- Decorative hero element instead of image --}}

            <div class="room-hero-side">

                <div class="room-hero-emblem">

                    <div class="room-emblem-inner">

                        <small>Room</small>

                        <strong>
                            {{ $room->room_number }}
                        </strong>

                        <span>
                            Your private space
                        </span>

                    </div>

                </div>

            </div>

        </div>

    </section>


    {{-- =========================================
         QUICK ROOM FACTS
    ========================================== --}}
    {{-- =========================================
     ACTUAL ROOM IMAGE
========================================= --}}

<section class="room-image-section">

    <div class="room-image-frame">

        @if($room->image)
            <img
                src="{{ Str::startsWith($room->image, ['http://', 'https://'])
                    ? $room->image
                    : asset('storage/' . $room->image) }}"
                alt="{{ optional($room->roomType)->name }}"
            >

        @elseif(optional($room->roomType)->image)

            <img
                src="{{ Str::startsWith($room->roomType->image, ['http://', 'https://'])
                    ? $room->roomType->image
                    : asset('storage/' . $room->roomType->image) }}"
                alt="{{ optional($room->roomType)->name }}"
            >

        @else

            <img
                src="{{ asset('images/default-room.jpg') }}"
                alt="{{ optional($room->roomType)->name }}"
            >

        @endif

    </div>

</section>

    <section class="room-facts-bar">

        <div class="room-facts-inner">

            <div class="room-fact">

                <div class="room-fact-icon">
                    <i class="fas fa-user"></i>
                </div>

                <div>
                    <small>Capacity</small>
                    <strong>
                        {{ $room->roomType->capacity }} Guests
                    </strong>
                </div>

            </div>


            <div class="room-fact">

                <div class="room-fact-icon">
                    <i class="fas fa-building"></i>
                </div>

                <div>
                    <small>Location</small>
                    <strong>
                        Floor {{ $room->floor ?? 'N/A' }}
                    </strong>
                </div>

            </div>


            <div class="room-fact">

                <div class="room-fact-icon">
                    <i class="fas fa-door-open"></i>
                </div>

                <div>
                    <small>Room</small>
                    <strong>
                        #{{ $room->room_number }}
                    </strong>
                </div>

            </div>


            <div class="room-fact">

                <div class="room-fact-icon">
                    <i class="fas fa-moon"></i>
                </div>

                <div>
                    <small>Stay</small>
                    <strong>
                        Per Night
                    </strong>
                </div>

            </div>

        </div>

    </section>


    {{-- =========================================
         MAIN INFORMATION
    ========================================== --}}

    <main class="room-detail-wrap">

        <div class="room-detail-grid">

            {{-- LEFT CONTENT --}}

            <div>

                <span class="room-section-label">
                    About The Room
                </span>

                <h2 class="room-main-heading">
                    Designed for comfort.<br>
                    Made for memorable stays.
                </h2>

                <p class="room-detail-desc">
                    {{ $room->roomType->description ?? 'A thoughtfully designed room offering comfort, elegance and a memorable stay experience.' }}
                </p>


                {{-- AMENITIES --}}

                @if($room->amenities->count())

                    <section class="room-amenities-section">

                        <span class="room-section-label">
                            Everything You Need
                        </span>

                        <h3 class="room-amenities-heading">
                            Room Amenities
                        </h3>

                        <div class="room-amenity-grid">

                            @foreach($room->amenities as $amenity)

                                <div class="room-amenity-item">

                                    <i class="fas fa-check"></i>

                                    <span>
                                        {{ $amenity->name }}
                                    </span>

                                </div>

                            @endforeach

                        </div>

                    </section>

                @endif

            </div>


            {{-- RIGHT BOOKING CARD --}}

            <aside>

                <div class="room-booking-card">

                    <div class="booking-card-top">

                        <div>

                            <div class="booking-card-label">
                                Stay in this room
                            </div>

                            <div class="room-booking-price">

                                ₹{{ number_format($room->roomType->price, 0) }}

                                <small>
                                    / night
                                </small>

                            </div>

                        </div>

                    </div>


                    <div class="booking-divider"></div>


                    <div class="booking-info-row">
                        <span>Room Type</span>
                        <span>
                            {{ $room->roomType->name }}
                        </span>
                    </div>


                    <div class="booking-info-row">
                        <span>Guests</span>
                        <span>
                            {{ $room->roomType->capacity }}
                        </span>
                    </div>


                    <div class="booking-info-row">
                        <span>Floor</span>
                        <span>
                            {{ $room->floor ?? 'N/A' }}
                        </span>
                    </div>


                    <div class="booking-info-row">
                        <span>Room Number</span>
                        <span>
                            {{ $room->room_number }}
                        </span>
                    </div>


                    @if($room->status)

                        <a
                            href="{{ route('frontend.bookings.create', $room->id) }}"
                            class="room-book-btn-full"
                        >
                            <i class="fas fa-calendar-check"></i>

                            Book This Room

                        </a>

                        <p class="booking-note">
                            Secure your stay in just a few steps.
                        </p>

                    @else

                        <button
                            class="room-book-btn-full is-disabled"
                            disabled
                        >
                            Not Available
                        </button>

                    @endif

                </div>

            </aside>

        </div>

    </main>


    {{-- =========================================
         BOTTOM EXPERIENCE SECTION
    ========================================== --}}

    <section class="room-experience">

        <div class="room-experience-inner">

            <span class="room-section-label" style="justify-content:center;">
                Your Stay
            </span>

            <h2>
                A space to slow down,
                relax and feel at home.
            </h2>

            <p>
                From thoughtful amenities to a comfortable atmosphere,
                every detail of this room is designed to make your stay
                effortless and enjoyable.
            </p>

        </div>

    </section>

</div>

@endsection
