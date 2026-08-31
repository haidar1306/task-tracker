@extends('frontend.layouts.app')

@section('title', 'Rooms')
@push('after-styles')
<style>
/* ===========================
   ROOM SECTION
=========================== */

.room-section{
     background: #c2e9ee;;
    padding:50px 0 10px;
}

/* Small Badge */

.room-subtitle{
    display:inline-block;
    padding:10px 28px;
    background:#d4af37;
    color:#fff;
    border-radius:50px;
    text-transform:uppercase;
    letter-spacing:3px;
    font-size:13px;
    font-weight:700;
    margin-bottom:30px;
    box-shadow:0 10px 30px rgba(212,175,55,.25);
}

/* Main Title */

.room-title{
    font-size:58px;
    font-weight:800;
    color:#1f2937;
    line-height:1.15;
    margin-bottom:20px;
    letter-spacing:-1px;
    font-family:Georgia, serif;
}

/* Gold Divider */

.room-divider{
    width:90px;
    height:4px;
    background:#d4af37;
    margin:0 auto 30px;
    border-radius:20px;
}

/* Description */

.room-desc{
    max-width:1000px;
    margin:auto;
    font-size:19px;
    line-height:1.9;
    color:#6b7280;
}

/* Decorative Text */

.room-watermark{
    position:absolute;
    top:30px;
    left:50%;
    transform:translateX(-50%);
    font-size:130px;
    font-weight:900;
    color:#000;
    opacity:.03;
    text-transform:uppercase;
    pointer-events:none;
    user-select:none;
    white-space:nowrap;
}

/* Responsive */

@media(max-width:768px){

.room-title{
    font-size:38px;
}

.room-desc{
    font-size:16px;
}

.room-watermark{
    display:none;
}
.room-section{
    background:#fff;
    padding:90px 0 40px;
}
.room-cards{
    margin-top:40px;
}
.room-watermark{
  font-size:100px;
    opacity:.02;
}
.room-title{
    font-size:52px;
}

}
</style>

@section('content')

    <section class="py-5">

        <div class="container">


            <div class="room-section">

                <div class="container">

                    <div class="text-center position-relative mb-5">

                        <div class="room-watermark">
                            HOTEL
                        </div>

                        <span class="room-subtitle">
                            Luxury Collection
                        </span>

                        <h2 class="room-title">
                            Discover Exceptional <br>
                            Luxury Rooms
                        </h2>

                        <div class="room-divider"></div>

                        <p class="room-desc">
                            Every room is thoughtfully crafted with elegant interiors,
                            premium comfort and modern hospitality to deliver a memorable
                            stay for every guest.
                        </p>

                    </div>

                    {{-- Room Cards --}}

                </div>

            </div>



            <div class="row">


                @foreach($rooms as $room)


                    <div class="col-lg-4 col-md-6 mb-4">


                        <div class="card shadow border-0 h-100">


                            @if($room->image)

                                <img src="{{ asset('storage/' . $room->image) }}" class="card-img-top"
                                    style="height:250px;object-fit:cover;">

                            @else

                                @if($room->roomType->image)

                                    <img src="{{ asset('storage/' . $room->roomType->image) }}" class="card-img-top"
                                        style="height:250px; object-fit:cover;">

                                @else

                                    <img src="{{ asset('images/default-room.jpg') }}" class="card-img-top"
                                        style="height:250px; object-fit:cover;">

                                @endif

                            @endif



                            <div class="card-body">


                                <h4>
                                    {{ $room->roomType->name ?? 'Room' }}
                                </h4>



                                <p>
                                    <i class="fas fa-door-open"></i>

                                    Room No :
                                    {{ $room->room_number }}

                                </p>
                                <p>

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



                                <p>
                                    <i class="fas fa-building"></i>

                                    Floor :
                                    {{ $room->floor->name ?? 'N/A' }}

                                </p>



                                <p>

                                    <i class="fas fa-users"></i>

                                    Capacity :
                                    {{ $room->roomType->capacity ?? '-' }}

                                    Guests

                                </p>



                                <h5 class="text-primary">

                                    ₹{{ number_format($room->roomType->price, 2) }}

                                    <small>
                                        / Night
                                    </small>

                                </h5>
                               <div class="mb-3">

    @foreach($room->amenities->take(5) as $amenity)

        <span class="badge badge-light mr-1">
            <i class="fas fa-check text-success"></i>
            {{ $amenity->name }}
        </span>

    @endforeach

</div>
                                



                                <a href="{{ route('frontend.room.show', $room->id) }}" class="btn btn-primary mt-3">

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