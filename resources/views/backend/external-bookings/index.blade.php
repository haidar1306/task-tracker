@extends('backend.layouts.app')

@section('title', 'Dubai Hotel Bookings')

@section('content')
    @include('includes.partials.messages')

    <div class="card shadow mb-4">

        <div class="card-header py-3 d-flex justify-content-between align-items-center">
            <h6 class="m-0 font-weight-bold text-primary">
                Dubai Hotel Bookings
            </h6>
        </div>

        <div class="card-body">

            <form method="GET"
                  action="{{ route('admin.bookings.external-bookings.index') }}"
                  class="admin-table-search-form mb-4">

                <div class="input-group">
                    <input
                        type="search"
                        name="search"
                        value="{{ request('search') }}"
                        class="form-control"
                        placeholder="Search booking reference or hotel name..."
                    >

                    <div class="input-group-append">
                        <button type="submit" class="btn btn-primary">
                            Search
                        </button>
                    </div>
                </div>

                @if(request()->filled('search'))
                    <a href="{{ route('admin.bookings.external-bookings.index') }}"
                       class="btn btn-secondary btn-sm mt-2">
                        Clear
                    </a>
                @endif
            </form>

            <div class="table-responsive">

                <table class="table table-bordered table-hover">

                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Booking Reference</th>
                            <th>Hotel</th>
                            <th>Check In</th>
                            <th>Check Out</th>
                            <th>Guests</th>
                            <th>Total</th>
                            <th>Booking Status</th>
                            <th>Payment</th>
                            <th width="100">Action</th>
                        </tr>
                    </thead>

                    <tbody>
                        @forelse($bookings as $booking)
                            <tr>
                                <td>
                                    {{ $bookings->firstItem() + $loop->index }}
                                </td>

                                <td>
                                    {{ $booking->booking_reference ?? 'N/A' }}
                                </td>

                                <td>{{ $booking->hotel_name }}</td>

                                <td>
                                    {{ $booking->check_in?->format('d M Y') }}
                                </td>

                                <td>
                                    {{ $booking->check_out?->format('d M Y') }}
                                </td>

                                <td>{{ $booking->guests }}</td>

                                <td>
                                    {{ $booking->currency }}
                                    {{ number_format((float) $booking->total_price, 2) }}
                                </td>

                                <td>
                                    @if($booking->status === 'confirmed')
                                        <span class="badge badge-success">Confirmed</span>
                                    @elseif($booking->status === 'cancelled')
                                        <span class="badge badge-danger">Cancelled</span>
                                    @elseif($booking->status === 'checked_out')
                                        <span class="badge badge-secondary">Checked Out</span>
                                    @else
                                        <span class="badge badge-warning">
                                            {{ ucfirst($booking->status ?? 'pending') }}
                                        </span>
                                    @endif
                                </td>

                                <td>
                                    @if($booking->payment_status === 'paid')
                                        <span class="badge badge-success">Paid</span>
                                    @else
                                        <span class="badge badge-warning">
                                            {{ ucfirst($booking->payment_status ?? 'unpaid') }}
                                        </span>
                                    @endif
                                </td>

                                <td>
                                    <a
                                        href="{{ route('admin.bookings.external-bookings.show', $booking->id) }}"
                                        class="btn btn-primary btn-sm"
                                        title="View Booking"
                                    >
                                        <i class="fas fa-eye"></i>
                                    </a>
                                </td>
                            </tr>

                        @empty
                            <tr>
                                <td colspan="10" class="text-center">
                                    {{ request()->filled('search')
                                        ? 'No matching Dubai bookings found.'
                                        : 'No Dubai bookings found.' }}
                                </td>
                            </tr>
                        @endforelse
                    </tbody>

                </table>

                @if($bookings->hasPages())
                    <div class="d-flex justify-content-between align-items-center mt-3">
                        <p class="mb-0 text-muted">
                            Showing {{ $bookings->firstItem() }}
                            to {{ $bookings->lastItem() }}
                            of {{ $bookings->total() }} results
                        </p>

                        {{ $bookings->links('pagination::admin') }}
                    </div>
                @endif

            </div>
        </div>
    </div>
@endsection