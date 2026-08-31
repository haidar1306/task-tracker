@extends('frontend.layouts.app')

@section('title', 'Book Room')

@section('content')

    <div class="container py-5">

        <div class="row justify-content-center">

            <div class="col-lg-8">

                <div class="card shadow">

                    <div class="card-header bg-primary text-white">

                        <h4 class="mb-0">
                            Book Room - {{ $room->room_number }}
                        </h4>

                    </div>

                    <div class="card-body">
                        <div class="alert alert-info">

                            <h5>{{ $room->roomType->name }}</h5>

                            <hr>

                            <strong>Price / Night :</strong>

                            ₹{{ number_format($room->roomType->price, 2) }}

                        </div>

                        <form action="{{ route('frontend.bookings.store') }}" method="POST">

                            @csrf

                            <input type="hidden" name="room_id" value="{{ $room->id }}">

                            <div class="form-group">
                                <label>Check In</label>
                                <input type="date" name="check_in" class="form-control" required>
                            </div>

                            <div class="form-group">
                                <label>Check Out</label>
                                <input type="date" name="check_out" class="form-control" required>
                            </div>

                            <div class="form-group">
                                <label>Adults</label>
                                <input type="number" name="adults" class="form-control" min="1" value="1">
                            </div>

                            <div class="form-group">
                                <label>Children</label>
                                <input type="number" name="children" class="form-control" min="0" value="0">
                            </div>

                            <button type="submit" class="btn btn-success">

                                Confirm Booking

                            </button>


                        </form>

                    </div>

                </div>

            </div>

        </div>

    </div>


@endsection
