
@extends('frontend.layouts.app')

@section('title', 'Book Dubai Hotel')

@section('content')
<div class="container py-5" style="max-width: 1000px;">

    <div class="mb-4">
        <h2 class="fw-bold">Book Your Dubai Stay</h2>
        <p class="text-muted">Review your hotel details and complete your booking.</p>
    </div>

    <div class="card shadow-sm border-0">
        <div class="card-body p-4">
            <div class="row g-4">

                <div class="col-md-5">
                    @if(!empty($hotel->image))
                        <img
                            src="{{ $hotel->image }}"
                            alt="{{ $hotel->name ?? 'Dubai Hotel' }}"
                            class="img-fluid rounded w-100"
                            style="max-height: 300px; object-fit: cover;"
                        >
                    @endif

                    <h4 class="mt-3">
                        {{ $hotel->name ?? 'Dubai Hotel' }}
                    </h4>

                    <p class="text-muted mb-0">
                        Dubai, United Arab Emirates
                    </p>
                </div>

                <div class="col-md-7">
                    <h5 class="mb-3">Booking Details</h5>

                    <table class="table table-bordered align-middle">
                        <tr>
                            <th>Check-in</th>
                            <td>
                                {{ \Carbon\Carbon::parse($search['check_in'])->format('d M Y') }}
                            </td>
                        </tr>
                        <tr>
                            <th>Check-out</th>
                            <td>
                                {{ \Carbon\Carbon::parse($search['check_out'])->format('d M Y') }}
                            </td>
                        </tr>
                        <tr>
                            <th>Nights</th>
                            <td>{{ $nights }}</td>
                        </tr>
                        <tr>
                            <th>Guests</th>
                            <td>{{ $search['guests'] }}</td>
                        </tr>
                        <tr>
                            <th>Total Price</th>
                            <td>
                                <strong>
                                    {{ $hotel->currency ?? 'INR' }}
                                    {{ number_format((float) ($hotel->total_price ?? 0), 2) }}
                                </strong>
                            </td>
                        </tr>
                    </table>

                    <form
                        action="{{ route('frontend.dubai-booking.store') }}"
                        method="POST"
                    >
                        @csrf

                        <input
                            type="hidden"
                            name="hotel_id"
                            value="{{ $search['hotel_id'] }}"
                        >

                        <input
                            type="hidden"
                            name="check_in"
                            value="{{ $search['check_in'] }}"
                        >

                        <input
                            type="hidden"
                            name="check_out"
                            value="{{ $search['check_out'] }}"
                        >

                        <input
                            type="hidden"
                            name="guests"
                            value="{{ $search['guests'] }}"
                        >

                        @if($errors->any())
                            <div class="alert alert-danger">
                                <ul class="mb-0">
                                    @foreach($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        <button type="submit" class="btn btn-dark btn-lg w-100">
                            Confirm Booking Details
                        </button>

                        <p class="small text-muted mt-3 mb-0">
                            You will proceed to the next booking step after submitting.
                            Payment is handled separately after check-out.
                        </p>
                    </form>

                    <a
                        href="{{ url()->previous() }}"
                        class="btn btn-outline-secondary mt-3 w-100"
                    >
                        Back to Hotels
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
