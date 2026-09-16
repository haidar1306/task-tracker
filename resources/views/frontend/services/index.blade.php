@extends('frontend.layouts.app')

@section('title', 'Services')

@push('after-styles')
<style>
    /* ===========================
       SERVICES HERO
    =========================== */

    .services-hero {
        position: relative;
        width: 100%;
        min-height: 46vh;
        display: flex;
        align-items: center;
        justify-content: center;
        background:
            linear-gradient(180deg, rgba(43,38,33,.55) 0%, rgba(43,38,33,.78) 100%),
             url('{{ asset("frontend/images/images (22).jfif") }}') center/cover no-repeat;
        text-align: center;
        margin-bottom: 70px;
    }

    .services-hero span.kicker {
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

    .services-hero h1 {
        font-family: 'Playfair Display', serif;
        font-size: clamp(2.2rem, 5vw, 3.6rem);
        font-weight: 700;
        color: #fffdfa;
        margin: 0 0 14px;
    }

    .services-hero p {
        max-width: 560px;
        margin: 0 auto;
        color: #e8dcc8;
        font-size: 16px;
        line-height: 1.8;
    }

    /* ===========================
       SERVICE CARDS
    =========================== */

    .services-section {
        padding: 0 0 90px;
        background: #f7f2ea;
    }

    .service-card {
        background: #fffdfa;
        border: 1px solid #e5dccb;
        border-radius: 16px;
        overflow: hidden;
        height: 100%;
        transition: transform .3s ease, box-shadow .3s ease;
    }

    .service-card:hover {
        transform: translateY(-8px);
        box-shadow: 0 18px 36px rgba(43, 38, 33, .12);
    }

    .service-card-image {
        position: relative;
        height: 220px;
        overflow: hidden;
        background: #eee2d0;
    }

    .service-card-image img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: transform .4s ease;
    }

    .service-card:hover .service-card-image img {
        transform: scale(1.06);
    }

    .service-card-icon {
        position: absolute;
        left: 20px;
        bottom: -26px;
        width: 56px;
        height: 56px;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 50%;
        background: #fffdfa;
        color: #a9825c;
        font-size: 22px;
        box-shadow: 0 10px 22px rgba(43, 38, 33, .16);
    }

    .service-card-body {
        padding: 42px 26px 28px;
        text-align: center;
    }

    .service-card-body h4 {
        font-family: 'Playfair Display', serif;
        color: #2b2621;
        font-size: 21px;
        font-weight: 700;
        margin-bottom: 12px;
    }

    .service-card-body p {
        color: #8a7f6f;
        font-size: 14.5px;
        line-height: 1.7;
        margin-bottom: 22px;
    }

    .service-view-btn {
        display: inline-block;
        padding: 10px 26px;
        border: 1px solid #a9825c;
        color: #a9825c;
        border-radius: 30px;
        text-decoration: none;
        font-weight: 600;
        font-size: 13px;
        letter-spacing: 0.03em;
        transition: 0.3s;
    }

    .service-view-btn:hover {
        background: #a9825c;
        color: #fff;
    }

    @media (max-width: 767.98px) {
        .services-hero {
            min-height: 36vh;
            margin-bottom: 50px;
        }

        .service-card-body {
            padding: 38px 20px 24px;
        }
    }
</style>
@endpush

@section('content')

    <section class="services-hero page-hero">
        <div class="container">
            <span class="kicker">What We Offer</span>
            <h1>Our Services</h1>
            <p>Experience premium hospitality services designed to make every stay effortless and memorable.</p>
        </div>
    </section>

    <section class="services-section">
        <div class="container">

            <div class="row g-4">

                @foreach($services as $service)

                    <div class="col-lg-4 col-md-6">

                        <div class="service-card">

                            <div class="service-card-image">

                                @if($service->image)
                                    <img src="{{ str_starts_with($service->image, 'http') ? $service->image : asset('uploads/services/' . $service->image) }}" alt="{{ $service->title }}">
                                @else
                                    <img src="{{ asset('images/default-service.jpg') }}" alt="{{ $service->title }}">
                                @endif

                                @if($service->icon)
                                    <span class="service-card-icon">
                                        <i class="{{ $service->icon }}"></i>
                                    </span>
                                @endif

                            </div>

                            <div class="service-card-body">

                                <h4>{{ $service->title }}</h4>

                                <p>{{ $service->short_description }}</p>

                                <a href="{{ route('frontend.services.show', $service->id) }}" class="service-view-btn">
                                    View Details
                                </a>

                            </div>

                        </div>

                    </div>

                @endforeach

            </div>

        </div>
    </section>

@endsection