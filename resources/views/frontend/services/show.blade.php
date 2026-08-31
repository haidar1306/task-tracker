@extends('frontend.layouts.app')

@section('content')
<style>
    .service-description{
    line-height:1.9;
    color:#666;
    font-size:16px;
}

.service-description p{
    margin-bottom:18px;
}

.btn-warning{
    background:#d4af37;
    border-color:#d4af37;
    color:#fff;
}

.btn-warning:hover{
    background:#b99222;
    border-color:#b99222;
}
</style>

<section class="py-5 bg-light">
    <div class="container">

        <div class="row align-items-center">

            <div class="col-lg-6 mb-4">

                <img src="{{ asset('uploads/services/'.$service->image) }}"
                     class="img-fluid rounded shadow"
                     alt="{{ $service->title }}">

            </div>

            <div class="col-lg-6">

                @if($service->icon)
                    <div class="mb-3">
                        <i class="{{ $service->icon }} fa-3x text-warning"></i>
                    </div>
                @endif

                <h2 class="fw-bold mb-3">
                    {{ $service->title }}
                </h2>

                @if($service->short_description)
                    <p class="lead text-muted">
                        {{ $service->short_description }}
                    </p>
                @endif

                <hr>

                <div class="service-description">
                    {!! nl2br(e($service->description)) !!}
                </div>

                <div class="mt-4">

                    <a href="{{ route('frontend.room.index') }}" class="btn btn-warning px-4">
                        Book Your Stay
                    </a>

                    <a href="{{ route('frontend.services') }}" class="btn btn-outline-dark ms-2">
                        Back to Services
                    </a>

                </div>

            </div>

        </div>

    </div>
</section>

@endsection