@extends('frontend.layouts.apps')

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

    /* Room status colours (used by the animated dot in the room number chip) */

    .room-type-available {
        background: #22a447;
    }

    .room-type-occupied {
        background: #f59e0b;
    }

    .room-type-maintenance {
        background: #dc2626;
    }

    .room-type-unknown {
        background: #918678;
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

    /* Booking availability badge */

    .room-status {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        padding: 10px 15px;
        border-radius: 30px;
        background: #eee9df;
        color: #6d6253;
        border: 1px solid #ddd3c2;
        font-family: 'Jost', sans-serif;
        font-size: 11px;
        font-weight: 600;
        letter-spacing: .8px;
        text-transform: uppercase;
    }

    .room-number-pill {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        padding: 9px 15px;
        border: 1px solid var(--room-border);
        border-radius: 30px;
        font-family: 'Jost', sans-serif;
        font-size: 11px;
        font-weight: 600;
        color: var(--room-text);
        text-transform: uppercase;
        letter-spacing: 1px;
        background: rgba(255,255,255,.55);
    }

    /* =========================================
       ANIMATED DOT (inside chips)
    ========================================= */

    .chip-dot {
        position: relative;
        display: inline-block;
        width: 8px;
        height: 8px;
        min-width: 8px;
        border-radius: 50%;
        flex-shrink: 0;
    }

    /* Expanding pulse ring */
    .chip-dot::after {
        content: "";
        position: absolute;
        inset: 0;
        border-radius: 50%;
        background: inherit;
        animation: chipDotPulse 1.9s cubic-bezier(.4, 0, .6, 1) infinite;
    }

    /* Soft glow per status */
    .chip-dot.room-type-available   { box-shadow: 0 0 7px rgba(34,164,71,.65); }
    .chip-dot.room-type-occupied    { box-shadow: 0 0 7px rgba(245,158,11,.65); }
    .chip-dot.room-type-maintenance { box-shadow: 0 0 7px rgba(220,38,38,.55); }
    .chip-dot.room-type-unknown     { box-shadow: 0 0 7px rgba(145,134,120,.45); }

    .chip-dot-orange {
        background: #f59e0b;
        box-shadow: 0 0 7px rgba(245,158,11,.65);
    }

    @keyframes chipDotPulse {
        0%   { transform: scale(1);   opacity: .7; }
        75%  { transform: scale(3.2); opacity: 0; }
        100% { transform: scale(3.2); opacity: 0; }
    }

    @media (prefers-reduced-motion: reduce) {
        .chip-dot::after {
            animation: none;
            opacity: 0;
        }
    }

    /* Alert icon for availability chip */
    .chip-alert-icon {
        font-size: 12px;
        color: #d97706;
        flex-shrink: 0;
    }

    .room-status-orange,
    .room-status-alert {
        background: #fdf3e2;
        border-color: #f1d9ab;
        color: #8a5a0b;
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

    .room-photo-placeholder {
        width: 100%;
        height: 100%;
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        gap: 12px;
        background: linear-gradient(135deg, #f3f0e9, #e5dfd3);
        color: #756d61;
        font-family: 'Jost', sans-serif;
    }

    .room-photo-placeholder i {
        color: var(--room-gold-dark);
        font-size: 34px;
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
        grid-template-columns: repeat(2, minmax(0, 1fr));
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
        font-size: 15px;
        width: 22px;
        min-width: 22px;
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

    .reservation-back {
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
        margin-top: 15px;
        color: #777;
        text-decoration: none;
        font-family: 'Jost', sans-serif;
        font-size: 10px;
        font-weight: 600;
        letter-spacing: 1.2px;
        text-transform: uppercase;
        transition: .25s ease;
    }

    .reservation-back i {
        font-size: 9px;
    }

    .reservation-back:hover {
        color: #191919;
        transform: translateX(-3px);
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

        .room-image-frame {
            height: 340px;
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
</style>
@endpush


@section('content')

@php
    /*
    |--------------------------------------------------------------------------
    | Room status
    |--------------------------------------------------------------------------
    | Expected database values: available, occupied, maintenance.
    | Supports common capitalization and surrounding spaces.
    */

    $roomStatus = strtolower(trim((string) ($room->status ?? '')));

    $roomStatusClass = match ($roomStatus) {
        'available' => 'room-type-available',
        'occupied' => 'room-type-occupied',
        'maintenance' => 'room-type-maintenance',
        default => 'room-type-unknown',
    };

    /*
    |--------------------------------------------------------------------------
    | Amenity icons
    |--------------------------------------------------------------------------
    */

    $getAmenityIcon = function ($name) {
        $name = strtolower(trim((string) $name));

        $amenityIcons = [
            'wi-fi'             => 'fas fa-wifi',
            'wifi'              => 'fas fa-wifi',
            'wireless internet' => 'fas fa-wifi',
            'internet'          => 'fas fa-globe',

            'swimming pool'     => 'fas fa-swimmer',
            'pool'              => 'fas fa-swimmer',

            'parking'           => 'fas fa-parking',
            'free parking'      => 'fas fa-parking',
            'car parking'       => 'fas fa-car',

            'tv'                => 'fas fa-tv',
            'television'        => 'fas fa-tv',
            'smart tv'          => 'fas fa-tv',

            'ac'                => 'fas fa-snowflake',
            'a/c'               => 'fas fa-snowflake',
            'air conditioning'  => 'fas fa-snowflake',
            'air conditioner'   => 'fas fa-snowflake',

            'restaurant'        => 'fas fa-utensils',
            'food'              => 'fas fa-utensils',
            'breakfast'         => 'fas fa-utensils',
            'dining'            => 'fas fa-utensils',
            'room service'      => 'fas fa-concierge-bell',
            'bar'               => 'fas fa-glass-martini-alt',
            'bar lounge'        => 'fas fa-glass-martini-alt',
            'minibar'           => 'fas fa-glass-martini-alt',

            'coffee'            => 'fas fa-coffee',
            'coffee maker'      => 'fas fa-coffee',
            'tea'               => 'fas fa-mug-hot',

            'gym'               => 'fas fa-dumbbell',
            'fitness center'    => 'fas fa-dumbbell',
            'fitness centre'    => 'fas fa-dumbbell',

            'spa'               => 'fas fa-spa',
            'massage'           => 'fas fa-spa',
            'laundry'           => 'fas fa-tshirt',
            'washing machine'   => 'fas fa-tshirt',

            'security'          => 'fas fa-shield-alt',
            'cctv'              => 'fas fa-video',
            'fire safety'       => 'fas fa-fire-extinguisher',
            'smoke detector'    => 'fas fa-fire-extinguisher',

            'balcony'           => 'fas fa-door-open',
            'terrace'           => 'fas fa-sun',
            'view'              => 'fas fa-mountain',
            'sea view'          => 'fas fa-water',
            'garden view'       => 'fas fa-leaf',

            'bathroom'          => 'fas fa-bath',
            'bathtub'           => 'fas fa-bath',
            'bath'              => 'fas fa-bath',
            'shower'            => 'fas fa-shower',
            'hot water'         => 'fas fa-shower',

            'telephone'         => 'fas fa-phone',
            'phone'             => 'fas fa-phone',
            'desk'              => 'fas fa-laptop',
            'work desk'         => 'fas fa-laptop',

            'bed'               => 'fas fa-bed',
            'extra bed'         => 'fas fa-bed',
            'wardrobe'          => 'fas fa-door-closed',
            'closet'            => 'fas fa-door-closed',

            'elevator'          => 'fas fa-building',
            'lift'              => 'fas fa-building',
            'wheelchair access' => 'fas fa-wheelchair',
            'accessible room'   => 'fas fa-wheelchair',

            'hair dryer'        => 'fas fa-wind',
            'iron'              => 'fas fa-tshirt',
            'refrigerator'      => 'fas fa-snowflake',
            'mini fridge'       => 'fas fa-snowflake',

            'complimentary toiletries' => 'fas fa-pump-soap',
            'toiletries'        => 'fas fa-pump-soap',
            'safe'              => 'fas fa-lock',
            'in-room safe'      => 'fas fa-lock',
            'newspaper'         => 'fas fa-newspaper',
            'pets allowed'      => 'fas fa-paw',
            'pet friendly'      => 'fas fa-paw',
        ];

        if (isset($amenityIcons[$name])) {
            return $amenityIcons[$name];
        }

        // Match longer names such as "Free Wi-Fi" or "Indoor Swimming Pool".
        foreach ($amenityIcons as $keyword => $icon) {
            if (strlen($keyword) >= 4 && str_contains($name, $keyword)) {
                return $icon;
            }
        }

        return 'fas fa-check';
    };
@endphp

<div class="room-page">

    {{-- =========================================
         MODERN ROOM HERO
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
                    {{ optional($room->roomType)->name ?? 'Room Details' }}
                </h1>

                <p class="room-hero-description">
                    {{ optional($room->roomType)->description ?? 'A thoughtfully designed room offering comfort, elegance and a memorable stay experience.' }}
                </p>

                <div class="room-hero-meta">

                    {{-- Availability chip: orange dot (dates selected) / alert icon (no dates or unavailable) --}}
                    @if($hasStayDates && $isBookable)
                        <span class="room-status room-status-orange">
                            <span class="chip-dot chip-dot-orange" aria-hidden="true"></span>
                            Available for selected dates
                        </span>
                    @elseif(!$hasStayDates && $isBookable)
                        <span class="room-status room-status-alert">
                            <i class="fas fa-exclamation-triangle chip-alert-icon" aria-hidden="true"></i>
                            Select dates to check availability
                        </span>
                    @else
                        <span class="room-status room-status-alert">
                            <i class="fas fa-exclamation-triangle chip-alert-icon" aria-hidden="true"></i>
                            Not available for selected dates
                        </span>
                    @endif

                    {{-- Room number chip: animated dot (admin room status colour) --}}
                    <span class="room-number-pill">
                        <span
                            class="chip-dot {{ $roomStatusClass }}"
                            title="{{ ucfirst($roomStatus ?: 'Status unknown') }}"
                            aria-label="Room status: {{ ucfirst($roomStatus ?: 'Unknown') }}"
                        ></span>
                        Room {{ $room->room_number }}
                    </span>

                    {{-- Bed type --}}
                    @if($room->bedType)
                        <span class="room-number-pill">
                            <i class="fas fa-bed" aria-hidden="true"></i>
                            {{ $room->bedType->name }}
                        </span>
                    @endif

                </div>

            </div>

            {{-- Decorative hero element --}}

            <div class="room-hero-side">

                <div class="room-hero-emblem">

                    <div class="room-emblem-inner">

                        <small>Room</small>

                        <strong>{{ $room->room_number }}</strong>

                        <span>Your private space</span>

                    </div>

                </div>

            </div>

        </div>

    </section>


    {{-- =========================================
         ACTUAL ROOM IMAGE
    ========================================== --}}

    <section class="room-image-section">

        <div class="room-image-frame">

            @if(optional($room->roomType)->room_photo_url)

                <img
                    src="{{ $room->roomType->room_photo_url }}"
                    alt="{{ optional($room->roomType)->name }} room"
                    loading="eager"
                >

            @else

                <div
                    class="room-photo-placeholder"
                    role="img"
                    aria-label="Room photograph not available"
                >
                    <i class="fas fa-bed" aria-hidden="true"></i>
                    <span>Room photograph not available</span>
                </div>

            @endif

        </div>

    </section>


    {{-- =========================================
         QUICK ROOM FACTS
    ========================================== --}}

    <section class="room-facts-bar">

        <div class="room-facts-inner">

            <div class="room-fact">

                <div class="room-fact-icon">
                    <i class="fas fa-user" aria-hidden="true"></i>
                </div>

                <div>
                    <small>Capacity</small>
                    <strong>
                        {{ optional($room->roomType)->capacity ?? 'N/A' }} Guests
                    </strong>
                </div>

            </div>

            <div class="room-fact">

                <div class="room-fact-icon">
                    <i class="fas fa-building" aria-hidden="true"></i>
                </div>

                <div>
                    <small>Location</small>
                    <strong>Floor {{ $room->floor ?? 'N/A' }}</strong>
                </div>

            </div>

            <div class="room-fact">

                <div class="room-fact-icon">
                    <i class="fas fa-door-open" aria-hidden="true"></i>
                </div>

                <div>
                    <small>Room</small>
                    <strong>#{{ $room->room_number }}</strong>
                </div>

            </div>

            <div class="room-fact">

                <div class="room-fact-icon">
                    <i class="fas fa-moon" aria-hidden="true"></i>
                </div>

                <div>
                    <small>Stay</small>
                    <strong>Per Night</strong>
                </div>

            </div>

        </div>

    </section>


    {{-- =========================================
         MAIN ROOM INFORMATION
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
                    {{ optional($room->roomType)->description ?? 'A thoughtfully designed room offering comfort, elegance and a memorable stay experience.' }}
                </p>


                {{-- =========================================
                     ROOM AMENITIES WITH MATCHING ICONS
                ========================================== --}}

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

                                @php
                                    $amenityIcon = $getAmenityIcon($amenity->name);
                                @endphp

                                <div class="room-amenity-item">

                                    <i
                                        class="{{ $amenityIcon }}"
                                        aria-hidden="true"
                                    ></i>

                                    <span>{{ $amenity->name }}</span>

                                </div>

                            @endforeach

                        </div>

                    </section>

                @else

                    <section class="room-amenities-section">

                        <span class="room-section-label">
                            Everything You Need
                        </span>

                        <h3 class="room-amenities-heading">
                            Room Amenities
                        </h3>

                        <p class="room-detail-desc" style="margin-bottom: 0;">
                            Amenity information is not available for this room.
                        </p>

                    </section>

                @endif

            </div>


            {{-- =========================================
                 RIGHT BOOKING CARD
            ========================================== --}}

            <aside>

                <div class="room-booking-card">

                    <div class="booking-card-top">

                        <div>

                            <div class="booking-card-label">
                                Stay in this room
                            </div>

                            <div class="room-booking-price">

                                ₹{{ number_format((float) optional($room->roomType)->price, 0) }}

                                <small>/ night</small>

                            </div>

                        </div>

                    </div>

                    <div class="booking-divider"></div>

                    <div class="booking-info-row">
                        <span>Room Type</span>
                        <span>
                            {{ optional($room->roomType)->name ?? 'N/A' }}
                        </span>
                    </div>

                    <div class="booking-info-row">
                        <span>Guests</span>
                        <span>
                            {{ optional($room->roomType)->capacity ?? 'N/A' }}
                        </span>
                    </div>

                    <div class="booking-info-row">
                        <span>Floor</span>
                        <span>{{ $room->floor ?? 'N/A' }}</span>
                    </div>

                    <div class="booking-info-row">
                        <span>Room Number</span>
                        <span>{{ $room->room_number }}</span>
                    </div>

                    @if($room->bedType)
                        <div class="booking-info-row">
                            <span>Bed Type</span>
                            <span>{{ $room->bedType->name }}</span>
                        </div>
                    @endif

                    @if($isBookable)

                        <a
                            href="{{ route('bookings.create', array_merge(['room' => $room->id], $search ?? [])) }}"
                            class="room-book-btn-full"
                        >
                            <i class="fas fa-calendar-check" aria-hidden="true"></i>

                            {{ $hasStayDates ? 'Book This Room' : 'Choose Dates' }}
                        </a>

                        <a
                            href="{{ route('frontend.room.index', $search ?? []) }}"
                            class="reservation-back"
                        >
                            <i class="fas fa-arrow-left" aria-hidden="true"></i>
                            Back to Rooms
                        </a>

                        <p class="booking-note">
                            {{ $hasStayDates
                                ? 'Availability checked for your selected stay.'
                                : 'Select dates to check availability for your stay.' }}
                        </p>

                    @else

                        <button
                            type="button"
                            class="room-book-btn-full is-disabled"
                            disabled
                        >
                            <i class="fas fa-ban" aria-hidden="true"></i>
                            Not Available
                        </button>

                        <a
                            href="{{ route('frontend.room.index', $search ?? []) }}"
                            class="reservation-back"
                        >
                            <i class="fas fa-arrow-left" aria-hidden="true"></i>
                            Back to Rooms
                        </a>

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