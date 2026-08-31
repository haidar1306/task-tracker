@extends('frontend.layouts.app')

@section('title', 'Room Types')

@section('content')

<div class="container py-5">

    <div class="text-center mb-5">
        <h2>Our Room Types</h2>
        <p>Choose the perfect room for your stay.</p>
    </div>

    <div class="row">

        @forelse($roomTypes as $roomType)

            <div class="col-md-4 mb-4">

                <div class="card shadow h-100">

                    <div class="card-body">

                        <h4>
                            {{ $roomType->name }}
                        </h4>

                        <p>
                            {{ $roomType->description }}
                        </p>

                        <p>
                            <strong>Capacity:</strong>
                            {{ $roomType->capacity }}
                        </p>

                        <p>
                            <strong>Price:</strong>
                            ₹{{ number_format($roomType->price, 2) }}
                            / Night
                        </p>

                        <a href="{{ route('frontend.room.index') }}"
                           class="btn btn-primary">

                            View Rooms

                        </a>

                    </div>

                </div>

            </div>

        @empty

            <div class="col-12 text-center">

                <h5>No Room Types Available</h5>

            </div>

        @endforelse

    </div>

</div>

@endsection