@extends('backend.layouts.app')

@section('title', 'Booking Details')

@section('content')
    @include('includes.partials.messages')

    <div class="card shadow">

        <div class="card-header d-flex justify-content-between align-items-center">
            <span>Booking Details</span>
            <a href="{{ route('admin.bookings.index') }}" class="btn btn-secondary btn-sm">
                <i class="fas fa-arrow-left"></i> Back
            </a>
        </div>

        <div class="card-body">

            <div class="row">
                <div class="col-md-6">
                    <p><strong>Booking No:</strong> {{ $booking->booking_no }}</p>
                    <p><strong>Guest:</strong> {{ optional($booking->guest)->full_name ?? '-' }}</p>
                    <p><strong>Room:</strong> {{ optional($booking->room)->room_number ?? '-' }}
                        ({{ optional(optional($booking->room)->roomType)->name }})</p>
                    <p><strong>Guests:</strong> {{ $booking->adults }} adult(s), {{ $booking->children }} child(ren)</p>
                </div>

                <div class="col-md-6">
                    <p><strong>Check In:</strong> {{ $booking->check_in->format('d M Y') }}</p>
                    <p><strong>Check Out:</strong> {{ $booking->check_out->format('d M Y') }}</p>
                    <p><strong>Nights:</strong> {{ $booking->nights() }}</p>
                    <p><strong>Amount:</strong> ₹{{ number_format($booking->total_amount, 2) }}
                        @if($booking->nightly_rate)
                            <small class="text-muted">(₹{{ number_format($booking->nightly_rate, 2) }} / night)</small>
                        @endif
                    </p>
                </div>
            </div>

            <p>
                <strong>Status:</strong>
                <span class="badge badge-{{ $booking->badgeClass() }}">{{ $booking->booking_status }}</span>
                &nbsp;<strong>Payment:</strong> {{ $booking->payment_status }}
            </p>

            @if($booking->booking_status === 'Pending' && $booking->expires_at)
                <p class="text-muted small">Auto-expires on {{ $booking->expires_at->format('d M Y, h:i A') }} if not confirmed.</p>
            @endif

            @if($booking->remarks)
                <p><strong>Remarks:</strong> {{ $booking->remarks }}</p>
            @endif

            <hr>

            <div class="d-flex flex-wrap" style="gap:8px;">

                @if($booking->booking_status === 'Pending')
                    <form action="{{ route('admin.bookings.confirm', $booking->id) }}" method="POST">
                        @csrf
                        <button type="submit" class="btn btn-success"><i class="fas fa-check"></i> Confirm Booking</button>
                    </form>

                    <form action="{{ route('admin.bookings.reject', $booking->id) }}" method="POST"
                          onsubmit="return confirm('Reject this booking?')">
                        @csrf
                        <button type="submit" class="btn btn-outline-danger"><i class="fas fa-ban"></i> Reject</button>
                    </form>
                @endif

                @if($booking->booking_status === 'Confirmed')
                    <form action="{{ route('admin.bookings.checkIn', $booking->id) }}" method="POST">
                        @csrf
                        <button type="submit" class="btn btn-primary" {{ $booking->canCheckInNow() ? '' : 'disabled' }}
                                title="{{ $booking->canCheckInNow() ? '' : 'The stay period of this booking has ended' }}">
                            <i class="fas fa-sign-in-alt"></i> Check In
                        </button>
                    </form>

                    @if($booking->canMarkNoShow())
                        <form action="{{ route('admin.bookings.noShow', $booking->id) }}" method="POST"
                              onsubmit="return confirm('Mark as no-show?')">
                            @csrf
                            <button type="submit" class="btn btn-dark"><i class="fas fa-user-slash"></i> No Show</button>
                        </form>
                    @endif
                @endif

                @if($booking->booking_status === 'Checked In')
                    <form action="{{ route('admin.bookings.checkOut', $booking->id) }}" method="POST">
                        @csrf
                        <button type="submit" class="btn btn-warning"><i class="fas fa-sign-out-alt"></i> Check Out</button>
                    </form>
                @endif

                @if(in_array($booking->booking_status, ['Pending', 'Confirmed'], true))
                    <form action="{{ route('admin.bookings.cancel', $booking->id) }}" method="POST"
                          onsubmit="return confirm('Cancel this booking?')">
                        @csrf
                        <button type="submit" class="btn btn-danger"><i class="fas fa-times"></i> Cancel Booking</button>
                    </form>
                @endif

            </div>

            @if($booking->booking_status === 'Confirmed' && !$booking->canCheckInNow())
                <p class="text-muted small mt-3 mb-0">Is booking ka stay khatam ho chuka hai, ab Check In nahi ho sakta. No Show mark karo.</p>
            @endif

        </div>
    </div>
@endsection