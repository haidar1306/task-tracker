@extends('frontend.layouts.app')

@section('title', 'Room Details')

@section('content')

    <div class="container py-5">
        @if($room->roomType->image)

            <img src="{{ asset('storage/' . $room->roomType->image) }}" class="img-fluid rounded mb-4"
                style="width:100%;height:450px;object-fit:cover;">

        @endif

        <h2>{{ $room->room_number }}</h2>

        <p><strong>Room Type:</strong> {{ $room->roomType->name }}</p>

        <p><strong>Capacity:</strong> {{ $room->roomType->capacity }}</p>

        <p><strong>Price:</strong> ₹{{ $room->roomType->price }}</p>
        <p>

            <strong>Status :</strong>

            @if($room->status)

                <span class="badge badge-success">
                    Available
                </span>

            @else

                <span class="badge badge-danger">
                    Not Available
                </span>

            @endif

        </p>

        <p>{{ $room->roomType->description }}</p>
        @if($room->amenities->count())

    <h4 class="mt-4">
        Amenities
    </h4>


    <div class="row">

        @foreach($room->amenities as $amenity)

            <div class="col-md-4 mb-2">

                <div class="card p-2 shadow-sm">

                    <i class="fas fa-check text-success"></i>

                    {{ $amenity->name }}

                </div>

            </div>

        @endforeach

    </div>

@endif

        @if($room->status)

            <a href="{{ route('frontend.bookings.create', $room->id) }}" class="btn btn-primary">
                Book Now
            </a>

        @else

            <button class="btn btn-secondary" disabled>
                Not Available
            </button>

        @endif

    </div>

@endsection