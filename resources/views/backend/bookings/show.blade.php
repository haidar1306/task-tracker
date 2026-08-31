@extends('backend.layouts.app')

@section('title', 'Booking Details')

@section('content')

    <div class="card shadow">

        <div class="card-header">
            Booking Details
        </div>

        <div class="card-body">

            <p>
                <strong>Booking No:</strong>
                {{ $booking->booking_no }}
            </p>

            <p>
                <strong>Room:</strong>
                {{ $booking->room->room_number }}
            </p>

            <p>
                <strong>Amount:</strong>
                ₹{{ number_format($booking->total_amount, 2) }}
            </p>

            <p>
                <strong>Check In:</strong>
                {{ optional($booking->check_in)->format('d-m-Y') }}
            </p>

            <p>
                <strong>Check Out:</strong>
                {{ optional($booking->check_out)->format('d-m-Y') }}
            </p>

            <p>
                <strong>Status:</strong>
                {{ $booking->booking_status }}
            </p>
            @if($booking->booking_status == 'Confirmed')

                <form action="{{ route('admin.bookings.checkIn', $booking->id) }}" method="POST" class="d-inline">
                    @csrf

                    <button type="submit" class="btn btn-primary mt-3">
                        <i class="fas fa-sign-in-alt"></i>
                        Check In
                    </button>
                </form>

            @endif
            @if($booking->booking_status == 'Checked In')

                <form action="{{ route('admin.bookings.checkOut', $booking->id) }}" method="POST" class="d-inline">
                    @csrf

                    <button type="submit" class="btn btn-warning mt-3">
                        <i class="fas fa-sign-out-alt"></i>
                        Check Out
                    </button>
                </form>

            @endif


            @if($booking->booking_status == 'Pending')

                <a href="{{ route('admin.bookings.confirm', $booking->id) }}" class="btn btn-success">

                    <i class="fas fa-check"></i>
                    Confirm Booking

                </a>
                @if($booking->booking_status == 'Confirmed')

                    <form action="{{ route('admin.bookings.checkIn', $booking->id) }}" method="POST" class="d-inline">
                        @csrf

                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-sign-in-alt"></i>
                            Check In
                        </button>
                    </form>

                @endif


                <a href="{{ route('admin.bookings.cancel', $booking->id) }}" class="btn btn-danger">

                    <i class="fas fa-times"></i>
                    Cancel Booking

                </a>

            @endif
        </div>


    </div>

@endsection