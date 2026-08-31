@extends('backend.layouts.app')

@section('title', 'Bookings')

@section('content')
 @include('includes.partials.messages')


    <div class="card shadow mb-4">

        <div class="card-header py-3 d-flex justify-content-between align-items-center">

            <h6 class="m-0 font-weight-bold text-primary">
                {{ $bookingPageTitle ?? 'Booking Management' }}
            </h6>

            <a href="{{ route('admin.bookings.create') }}" class="btn btn-primary btn-sm">
                <i class="fas fa-plus"></i> Add Booking
            </a>

        </div>

        <div class="card-body">

            <!-- @include('includes.partials.messages') -->

            <form method="GET" action="{{ route('admin.bookings.index') }}" class="admin-table-search-form mb-4">
                <div class="input-group">
                    <input id="booking-search" type="search" name="search" value="{{ request('search') }}"
                           class="form-control" placeholder="Search booking no or guest name...">
                    <div class="input-group-append">
                        <button type="submit" class="btn btn-primary">Search</button>
                    </div>
                </div>

                @if(request()->filled('search'))
                    <a href="{{ route('admin.bookings.index') }}" class="btn btn-secondary btn-sm mt-2">Clear</a>
                @endif
            </form>

            <div class="table-responsive">

                <table class="table table-bordered table-hover">

                    <thead>

                        <tr>
                            <th>#</th>
                            <th>Booking No</th>
                            <th>Guest</th>
                            <th>Room</th>
                            <th>Check In</th>
                            <th>Check Out</th>
                            <th>Total</th>
                            <th>Booking Status</th>
                            <th>Payment</th>
                            <th>Status</th>
                            <th width="130">Action</th>
                        </tr>

                    </thead>

                    <tbody>

                        @forelse($bookings as $booking)

                            <tr>

                              <td>{{ $bookings->firstItem() + $loop->index }}</td>
                              
                                <td>
                                    @if(request()->filled('search'))
                                        {!! preg_replace(
                                            '/('.preg_quote(e(request('search')), '/').')/i',
                                            '<mark class="user-search-match">$1</mark>',
                                            e($booking->booking_no)
                                        ) !!}
                                    @else
                                        {{ $booking->booking_no }}
                                    @endif
                                </td>

                                <td>
                                    @if(request()->filled('search'))
                                        {!! preg_replace(
                                            '/('.preg_quote(e(request('search')), '/').')/i',
                                            '<mark class="user-search-match">$1</mark>',
                                            e(optional($booking->guest)->full_name)
                                        ) !!}
                                    @else
                                        {{ optional($booking->guest)->full_name }}
                                    @endif
                                </td>

                                <td>{{ optional($booking->room)->room_number }}</td>

                                <td>{{ $booking->check_in }}</td>

                                <td>{{ $booking->check_out }}</td>

                                <td>₹ {{ number_format($booking->total_amount, 2) }}</td>

                                <td>

                                    @if($booking->booking_status == 'Pending')

                                        <span class="badge badge-warning">
                                            Pending
                                        </span>

                                    @elseif($booking->booking_status == 'Confirmed')

                                        <span class="badge badge-success">
                                            Confirmed
                                        </span>

                                    @elseif($booking->booking_status == 'Cancelled')

                                        <span class="badge badge-danger">
                                            Cancelled
                                        </span>

                                    @elseif($booking->booking_status == 'Checked In')

                                        <span class="badge badge-primary">
                                            Checked In
                                        </span>

                                    @elseif($booking->booking_status == 'Checked Out')

                                        <span class="badge badge-secondary">
                                            Checked Out
                                        </span>

                                    @endif

                                </td>

                                <td>
                                    <span class="badge badge-warning">
                                        {{ $booking->payment_status }}
                                    </span>
                                </td>

                                <td>

                                    @if($booking->status)

                                        <span class="badge badge-success">
                                            Active
                                        </span>

                                    @else

                                        <span class="badge badge-danger">
                                            Inactive
                                        </span>

                                    @endif

                                </td>

                                <td>
                                    <a href="{{ route('admin.bookings.show', $booking->id) }}" class="btn btn-primary btn-sm">

                                        <i class="fas fa-eye"></i>

                                    </a>

                                    <a href="{{ route('admin.bookings.edit', $booking->id) }}" class="btn btn-info btn-sm">

                                        <i class="fas fa-edit"></i>

                                    </a>

                                    <form action="{{ route('admin.bookings.destroy', $booking->id) }}" method="POST"
                                        class="d-inline">

                                        @csrf
                                        @method('DELETE')

                                        <button class="btn btn-danger btn-sm" onclick="return confirm('Delete Booking?')">

                                            <i class="fas fa-trash"></i>

                                        </button>

                                    </form>

                                </td>

                            </tr>

                        @empty

                            <tr>

                                <td colspan="11" class="text-center">
                                    {{ request()->filled('search') ? 'Not Found' : 'No Bookings Found.' }}
                                </td>

                            </tr>

                        @endforelse

                    </tbody>

                </table>
                 @if ($bookings->hasPages())
    <div class="d-flex justify-content-between align-items-center mt-3">
        <p class="mb-0 text-muted">
            Showing {{ $bookings->firstItem() }} to {{ $bookings->lastItem() }}
            of {{ $bookings->total() }} results
        </p>

        {{ $bookings->links() }}
    </div>
@endif


            </div>

        </div>

    </div>
   

@endsection

@push('after-scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const searchInput = document.getElementById('booking-search');
            const searchForm = searchInput ? searchInput.form : null;
            let searchTimer;

            if (!searchInput || !searchForm) {
                return;
            }

            searchInput.addEventListener('input', function () {
                clearTimeout(searchTimer);
                searchTimer = setTimeout(function () {
                    searchForm.submit();
                }, 400);
            });
        });
    </script>
@endpush