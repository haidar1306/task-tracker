@extends('frontend.layouts.app')

@section('content')
    <style>
        /* ==========================
           SERVICES PAGE
        ========================== */
        .service-card {
            background: #fff;
            border-radius: 15px;
            padding: 30px;
            text-align: center;
            transition: .3s;
            height: 100%;
            box-shadow: 0 5px 20px rgba(0, 0, 0, .08);
        }

        .service-card:hover {
            transform: translateY(-8px);
        }

        .service-card img {
            height: 220px;
            width: 100%;
            object-fit: cover;
            border-radius: 12px;
        }

        .service-card i {
            color: #d4af37;
        }
    </style>

    <section class="services py-5">
        <div class="container">

            <div class="text-center mb-5">
                <h2>Our Services</h2>
                <p>Experience premium hospitality services.</p>
            </div>

            <div class="row">

                @foreach($services as $service)

                    <div class="col-lg-4 col-md-6 mb-4">

                        <div class="service-card">

                            @if($service->image)
                                <img src="{{ asset('uploads/services/' . $service->image) }}" class="img-fluid rounded mb-3">
                            @endif

                            @if($service->icon)
                                <i class="{{ $service->icon }} fa-2x mb-3"></i>
                            @endif

                            <h4>{{ $service->title }}</h4>

                            <p>
                                {{ $service->short_description }}
                            </p>

                            <div class="mt-4">

                                <a href="{{ route('frontend.services.show', $service->id) }}"  class="btn btn-outline-dark ms-2">
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