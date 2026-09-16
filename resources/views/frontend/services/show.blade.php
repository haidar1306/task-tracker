@extends('frontend.layouts.app')

@section('title', $service->title)

@push('after-styles')
<style>
    /* ===========================
       SERVICE HERO (full image banner)
    =========================== */

    .service-hero {
        position: relative;
        width: 100%;
        min-height: 52vh;
        display: flex;
        align-items: flex-end;
        background:
            linear-gradient(180deg, rgba(43,38,33,.25) 0%, rgba(43,38,33,.85) 100%),
            url('{{ str_starts_with($service->image ?? "", "http") ? $service->image : asset("uploads/services/" . $service->image) }}') center/cover no-repeat;
        margin-bottom: 60px;
    }

    .service-hero-content {
        width: 100%;
        padding: 60px 0 46px;
    }

    .service-hero-icon {
        width: 64px;
        height: 64px;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 50%;
        background: #fffdfa;
        color: #a9825c;
        font-size: 26px;
        margin-bottom: 22px;
        box-shadow: 0 10px 24px rgba(43, 38, 33, .2);
    }

    .service-hero-content h1 {
        font-family: 'Playfair Display', serif;
        font-size: clamp(2rem, 4.5vw, 3.2rem);
        font-weight: 700;
        color: #fffdfa;
        margin: 0 0 12px;
    }

    .service-hero-content p {
        max-width: 600px;
        color: #e8dcc8;
        font-size: 16px;
        line-height: 1.8;
        margin: 0;
    }

    /* ===========================
       CONTENT + STICKY BOOKING CARD
    =========================== */

    .service-detail-section {
        padding: 0 0 100px;
        background: #f7f2ea;
    }

    .service-description {
        color: #6b5f52;
        font-size: 16px;
        line-height: 1.95;
    }

    .service-description p {
        margin-bottom: 18px;
    }

    .service-info-card {
        position: sticky;
        top: 100px;
        background: #fffdfa;
        border: 1px solid #e5dccb;
        border-radius: 16px;
        padding: 32px 28px;
        box-shadow: 0 18px 40px rgba(43, 38, 33, .08);
    }

    .service-info-card h5 {
        font-family: 'Playfair Display', serif;
        color: #2b2621;
        font-size: 19px;
        font-weight: 700;
        margin-bottom: 20px;
    }

    .service-info-list {
        list-style: none;
        padding: 0;
        margin: 0 0 26px;
    }

    .service-info-list li {
        display: flex;
        align-items: center;
        gap: 12px;
        color: #6b5f52;
        font-size: 14px;
        padding: 10px 0;
        border-bottom: 1px solid #f0e6d4;
    }

    .service-info-list li:last-child {
        border-bottom: none;
    }

    .service-info-list i {
        color: #a9825c;
        width: 18px;
    }

    .service-info-card .btn-gold {
        display: block;
        width: 100%;
        text-align: center;
        background: #a9825c;
        color: #fff;
        padding: 13px;
        border-radius: 8px;
        text-decoration: none;
        font-weight: 600;
        font-size: 14px;
        letter-spacing: 0.03em;
        text-transform: uppercase;
        margin-bottom: 12px;
        transition: 0.25s;
    }

    .service-info-card .btn-gold:hover {
        background: #8a6844;
        color: #fff;
    }

    .service-info-card .btn-outline-back {
        display: block;
        width: 100%;
        text-align: center;
        background: transparent;
        border: 1px solid #e5dccb;
        color: #6b5f52;
        padding: 12px;
        border-radius: 8px;
        text-decoration: none;
        font-weight: 600;
        font-size: 13px;
        transition: 0.25s;
    }

    .service-info-card .btn-outline-back:hover {
        border-color: #a9825c;
        color: #a9825c;
    }

    @media (max-width: 991.98px) {
        .service-info-card {
            position: static;
            margin-top: 40px;
        }
    }
</style>
@endpush

@section('content')

    <section class="service-hero page-hero">
        <div class="container">
            <div class="service-hero-content">

                @if($service->icon)
                    <div class="service-hero-icon">
                        <i class="{{ $service->icon }}"></i>
                    </div>
                @endif

                <h1>{{ $service->title }}</h1>

                @if($service->short_description)
                    <p>{{ $service->short_description }}</p>
                @endif

            </div>
        </div>
    </section>

    <section class="service-detail-section">
        <div class="container">

            <div class="row">

                <div class="col-lg-8">
                    <div class="service-description">
                        {!! nl2br(e($service->description)) !!}
                    </div>
                </div>

                <div class="col-lg-4">
                    <div class="service-info-card">

                        <h5>Interested in this service?</h5>

                        <ul class="service-info-list">
                            <li><i class="fas fa-check-circle"></i> Available for all room types</li>
                            <li><i class="fas fa-clock"></i> Flexible scheduling</li>
                            <li><i class="fas fa-concierge-bell"></i> Arranged by our concierge team</li>
                        </ul>

                        <a href="{{ route('frontend.room.index') }}" class="btn-gold">
                            Book Your Stay
                        </a>

                        <a href="{{ route('frontend.services') }}" class="btn-outline-back">
                            &larr; Back to Services
                        </a>

                    </div>
                </div>

            </div>

        </div>
    </section>

@endsection