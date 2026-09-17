@extends('frontend.layouts.app')

@section('title', 'Services')

@push('after-styles')
<style>
    /* =========================================================
       HOTEL LUXURA — SERVICES EXPERIENCE
       Full-bleed background + cascading editorial cards
    ========================================================= */

    .luxura-services {
        position: relative;
        min-height: calc(100vh - 84px);
        margin-top: -24px;
        padding: 130px 0 110px;
        overflow: hidden;

        background:
            linear-gradient(
                180deg,
                rgba(14, 20, 22, 0.35) 0%,
                rgba(14, 20, 22, 0.15) 30%,
                rgba(14, 20, 22, 0.55) 100%
            ),
            url('{{ asset("frontend/images/bg.png") }}')
            center center / cover no-repeat;
    }

    /* subtle cinematic vignette */
    .luxura-services::before {
        content: "";
        position: absolute;
        inset: 0;
        background:
            radial-gradient(
                ellipse 90% 70% at 15% 50%,
                rgba(10, 15, 17, .55),
                transparent 60%
            );
        pointer-events: none;
    }

    .luxura-services .container-fluid {
        position: relative;
        z-index: 2;
        max-width: 1580px;
        padding: 0 60px;
    }

    /* =========================================================
       PAGE LAYOUT — intro left / cascade right
    ========================================================= */

    .services-layout {
        display: grid;
        grid-template-columns: 360px 1fr;
        gap: 40px;
        align-items: start;
    }

    /* =========================================================
       INTRO COLUMN
    ========================================================= */

    .services-intro {
        position: sticky;
        top: 140px;
        color: #fff;
        padding-top: 60px;
    }

    .services-kicker {
        display: flex;
        align-items: center;
        gap: 10px;
        font-family: "Jost", sans-serif;
        font-size: 11px;
        font-weight: 600;
        letter-spacing: 3px;
        text-transform: uppercase;
        color: #e7dcc4;
        margin-bottom: 18px;
    }

    .services-kicker::after {
        content: "";
        width: 32px;
        height: 1px;
        background: #e7dcc4;
    }

    .services-intro h1 {
        font-family: "Playfair Display", Georgia, serif;
        font-style: italic;
        font-size: clamp(38px, 3.6vw, 54px);
        font-weight: 500;
        line-height: 1.12;
        margin: 0;
        color: #fffdf8;
        text-shadow: 0 5px 25px rgba(0,0,0,.25);
    }

    .services-intro p {
        max-width: 320px;
        margin: 22px 0 0;
        color: rgba(255,255,255,.78);
        font-family: "Jost", sans-serif;
        font-size: 14.5px;
        line-height: 1.85;
    }

    .services-explore {
        display: inline-flex;
        align-items: center;
        gap: 16px;
        margin-top: 34px;
        text-decoration: none;
    }

    .services-explore .dot {
        display: flex;
        align-items: center;
        justify-content: center;
        width: 46px;
        height: 46px;
        border-radius: 50%;
        border: 1px solid rgba(255,255,255,.45);
        color: #fff;
        flex-shrink: 0;
        transition: .3s ease;
    }

    .services-explore .dot i {
        font-size: 12px;
        margin-left: 2px;
    }

    .services-explore span:last-child {
        font-family: "Jost", sans-serif;
        font-size: 11px;
        font-weight: 600;
        letter-spacing: 2px;
        text-transform: uppercase;
        color: rgba(255,255,255,.85);
    }

    .services-explore:hover .dot {
        background: #a9825c;
        border-color: #a9825c;
    }

    .services-bottom-note {
        margin-top: 70px;
        display: flex;
        align-items: center;
        gap: 14px;
        color: rgba(255,255,255,.6);
        font-family: "Jost", sans-serif;
        font-size: 10.5px;
        letter-spacing: 2px;
        text-transform: uppercase;
    }

    .services-bottom-note span.rule {
        width: 40px;
        height: 1px;
        background: rgba(255,255,255,.4);
    }

    /* =========================================================
       CASCADE — card track
    ========================================================= */

    .services-cascade-wrap {
        position: relative;
    }

    .floating-services {
        display: flex;
        align-items: flex-start;
        gap: 0;
        padding: 40px 10px 70px 0;
        overflow-x: auto;
        scroll-snap-type: x proximity;
        scrollbar-width: none;
    }

    .floating-services::-webkit-scrollbar {
        display: none;
    }

    /* =========================================================
       SERVICE CARD
    ========================================================= */

    .floating-service {
        position: relative;
        flex: 0 0 250px;
        min-height: 430px;
        margin-left: -58px;
        scroll-snap-align: start;

        background: rgba(20, 22, 22, .92);
        border: 1px solid rgba(255,255,255,.14);
        box-shadow:
            0 25px 55px rgba(0,0,0,.35),
            0 5px 15px rgba(0,0,0,.15);

        overflow: hidden;

        transform:
            translateY(var(--float-y, 0))
            rotate(var(--rotate, 0deg));

        transition:
            transform .5s cubic-bezier(.2,.8,.2,1),
            box-shadow .4s ease,
            border-color .4s ease,
            z-index 0s;
    }

    .floating-service:first-child {
        margin-left: 0;
    }

    /* stagger + depth so later cards sit above earlier ones */
    .floating-services article:nth-child(1) { --float-y: 0px;   --rotate: -1deg;   z-index: 5; }
    .floating-services article:nth-child(2) { --float-y: 55px;  --rotate: .6deg;   z-index: 6; }
    .floating-services article:nth-child(3) { --float-y: -18px; --rotate: -.8deg;  z-index: 7; }
    .floating-services article:nth-child(4) { --float-y: 32px;  --rotate: .9deg;   z-index: 8; }
    .floating-services article:nth-child(5) { --float-y: 60px;  --rotate: -.5deg;  z-index: 9; }
    .floating-services article:nth-child(n+6) { --float-y: 10px; --rotate: .5deg; }

    /* alternate light card for rhythm, mirrors the reference's cream panel */
    .floating-service.is-alt {
        background: #f4f0e6;
        border-color: rgba(0,0,0,.06);
    }

    .floating-service.is-alt .floating-service-body h3,
    .floating-service.is-alt .service-number {
        color: #1c1a16;
    }

    .floating-service.is-alt .floating-service-body p {
        color: rgba(28,26,22,.62);
    }

    .floating-service.is-alt .service-link {
        color: #a9825c;
    }

    .floating-service.is-alt .floating-service-icon {
        color: #a9825c;
        border-color: rgba(0,0,0,.15);
        background: rgba(255,255,255,.5);
    }

    /* =========================================================
       HOVER / FOCUS
    ========================================================= */

    .floating-service:hover,
    .floating-service:focus-within {
        transform:
            translateY(calc(var(--float-y) - 14px))
            rotate(0deg);
        z-index: 20;
        border-color: rgba(224, 199, 154, .55);
        box-shadow:
            0 40px 80px rgba(0,0,0,.45),
            0 8px 25px rgba(0,0,0,.2);
    }

    /* =========================================================
       IMAGE
    ========================================================= */

    .floating-service-image {
        position: relative;
        height: 260px;
        overflow: hidden;
        background: #262626;
    }

    .floating-service-image::after {
        content: "";
        position: absolute;
        inset: 0;
        background: linear-gradient(180deg, transparent 40%, rgba(0,0,0,.7) 100%);
        pointer-events: none;
    }

    .floating-service-image img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: transform .8s cubic-bezier(.2,.7,.2,1), filter .5s ease;
    }

    .floating-service:hover .floating-service-image img {
        transform: scale(1.06);
        filter: brightness(1.04);
    }

    /* =========================================================
       NUMBER + ICON
    ========================================================= */

    .service-number {
        position: absolute;
        top: 18px;
        left: 20px;
        z-index: 3;
        font-family: "Playfair Display", Georgia, serif;
        font-size: 15px;
        color: rgba(255,255,255,.9);
    }

    .floating-service-icon {
        position: absolute;
        right: 18px;
        top: 16px;
        z-index: 3;
        width: 36px;
        height: 36px;
        display: flex;
        align-items: center;
        justify-content: center;
        border: 1px solid rgba(255,255,255,.35);
        border-radius: 50%;
        color: #eee1c8;
        background: rgba(20,20,20,.35);
        backdrop-filter: blur(8px);
        -webkit-backdrop-filter: blur(8px);
        font-size: 13px;
        transition: .35s ease;
    }

    .floating-service:hover .floating-service-icon {
        background: #a9825c;
        border-color: #a9825c;
        color: #fff;
    }

    /* =========================================================
       BODY
    ========================================================= */

    .floating-service-body {
        padding: 24px 22px 26px;
        color: white;
    }

    .floating-service-body h3 {
        font-family: "Playfair Display", Georgia, serif;
        font-size: 22px;
        font-weight: 500;
        color: #fffdf8;
        margin: 0 0 9px;
    }

    .floating-service-body p {
        font-family: "Jost", sans-serif;
        color: rgba(255,255,255,.65);
        font-size: 12.5px;
        line-height: 1.7;
        margin: 0 0 16px;
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }

    .service-link {
        display: inline-flex;
        align-items: center;
        gap: 9px;
        color: #d9c29a;
        font-family: "Jost", sans-serif;
        font-size: 10.5px;
        font-weight: 600;
        letter-spacing: 1.5px;
        text-transform: uppercase;
        text-decoration: none;
        transition: .3s ease;
    }

    .service-link i {
        font-size: 9px;
        transition: transform .3s ease;
    }

    .service-link:hover {
        color: #fff;
        text-decoration: none;
    }

    .service-link:hover i {
        transform: translateX(5px);
    }

    /* =========================================================
       TRACK NAV ARROWS
    ========================================================= */

    .services-track-nav {
        position: absolute;
        bottom: 10px;
        right: 4px;
        display: flex;
        gap: 10px;
        z-index: 15;
    }

    .services-track-nav button {
        width: 44px;
        height: 44px;
        border-radius: 50%;
        border: 1px solid rgba(255,255,255,.4);
        background: rgba(20,20,20,.3);
        color: #fff;
        display: flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        backdrop-filter: blur(6px);
        transition: .3s ease;
    }

    .services-track-nav button:hover {
        background: #a9825c;
        border-color: #a9825c;
    }

    /* =========================================================
       TABLET
    ========================================================= */

    @media (max-width: 991.98px) {

        .luxura-services {
            padding: 100px 0 80px;
        }

        .luxura-services .container-fluid {
            padding: 0 24px;
        }

        .services-layout {
            grid-template-columns: 1fr;
            gap: 10px;
        }

        .services-intro {
            position: static;
            padding-top: 0;
            margin-bottom: 30px;
        }

        .services-intro p {
            max-width: 480px;
        }

        .floating-service {
            flex: 0 0 240px;
            min-height: 400px;
            margin-left: -30px;
        }

        .floating-services article:nth-child(n) {
            --float-y: 0px;
            --rotate: 0deg;
        }
    }

    /* =========================================================
       MOBILE
    ========================================================= */

    @media (max-width: 575.98px) {

        .luxura-services .container-fluid {
            padding: 0 16px;
        }

        .services-intro h1 {
            font-size: 36px;
        }

        .floating-services {
            padding-bottom: 50px;
        }

        .floating-service {
            flex: 0 0 78vw;
            min-height: 380px;
            margin-left: -14px;
        }

        .floating-service-image {
            height: 210px;
        }

        .services-track-nav {
            bottom: -6px;
        }
    }
</style>
@endpush


@section('content')

<section class="luxura-services">

    <div class="container-fluid">

        <div class="services-layout">

            {{-- INTRO --}}
            <div class="services-intro">

                <span class="services-kicker">Our Services</span>

                <h1>More Than<br>Just a Stay</h1>

                <p>
                    From personalized experiences to world-class amenities, our
                    services are designed to make your stay effortless,
                    comfortable and memorable.
                </p>

                <a href="#service-cascade" class="services-explore">
                    <span class="dot"><i class="fas fa-play"></i></span>
                    <span>Explore Luxury</span>
                </a>

                <div class="services-bottom-note">
                    <span class="rule"></span>
                    Luxury Hospitality
                </div>

            </div>

            {{-- CASCADING SERVICE CARDS --}}
            <div class="services-cascade-wrap">

                <div class="floating-services" id="service-cascade">

                    @foreach($services as $index => $service)

                        <article class="floating-service @if($index === 1) is-alt @endif">

                            <div class="floating-service-image">

                                <span class="service-number">
                                    {{ str_pad($index + 1, 2, '0', STR_PAD_LEFT) }}
                                </span>

                                @if($service->icon)
                                    <span class="floating-service-icon">
                                        <i class="{{ $service->icon }}"></i>
                                    </span>
                                @endif

                                <img
                                    src="{{ $service->image
                                        ? (str_starts_with($service->image, 'http')
                                            ? $service->image
                                            : asset('uploads/services/' . $service->image))
                                        : asset('images/default-service.jpg') }}"
                                    alt="{{ $service->title }}"
                                    loading="lazy"
                                >

                            </div>

                            <div class="floating-service-body">

                                <h3>{{ $service->title }}</h3>

                                <p>{{ $service->short_description }}</p>

                                <a href="{{ route('frontend.services.show', $service->id) }}" class="service-link">
                                    View Details
                                    <i class="fas fa-arrow-right"></i>
                                </a>

                            </div>

                        </article>

                    @endforeach

                </div>

                <div class="services-track-nav">
                    <button type="button" id="servicesPrev" aria-label="Previous service">
                        <i class="fas fa-arrow-left"></i>
                    </button>
                    <button type="button" id="servicesNext" aria-label="Next service">
                        <i class="fas fa-arrow-right"></i>
                    </button>
                </div>

            </div>

        </div>

    </div>

</section>

@endsection

@push('after-scripts')
<script>
    (function () {
        var track = document.getElementById('service-cascade');
        var prev = document.getElementById('servicesPrev');
        var next = document.getElementById('servicesNext');
        if (!track || !prev || !next) return;

        var step = 250;

        prev.addEventListener('click', function () {
            track.scrollBy({ left: -step, behavior: 'smooth' });
        });

        next.addEventListener('click', function () {
            track.scrollBy({ left: step, behavior: 'smooth' });
        });
    })();
</script>
@endpush