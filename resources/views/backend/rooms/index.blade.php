@extends('backend.layouts.app')

@section('title', 'Rooms')

@section('content')

<div class="card shadow mb-4">
    

    <div class="card-header py-3 d-flex justify-content-between align-items-center">

        <h6 class="m-0 font-weight-bold text-primary">
            Rooms
        </h6>

        <a href="{{ route('admin.rooms.create') }}" class="btn btn-primary btn-sm">
            <i class="fas fa-plus"></i> Add Room
        </a>

    </div>

    <div class="card-body">
        @include('includes.partials.messages')

        <form method="GET" action="{{ route('admin.rooms.index') }}" class="admin-table-search-form mb-4">
            <div class="input-group">
                <input id="room-search" type="search" name="search" value="{{ request('search') }}"
                       class="form-control" placeholder="Search room...">

                <div class="input-group-append">
                    <button type="submit" class="btn btn-primary">Search</button>

                    @if(request()->filled('search'))
                        <a href="{{ route('admin.rooms.index') }}" class="btn btn-secondary">Clear</a>
                    @endif
                </div>
            </div>
        </form>

        <div class="table-responsive">

            <table class="table table-bordered table-hover">

                <thead class="thead-light">

                    <tr>
                        <th width="60">#</th>
                        <th>Room No.</th>
                        <th>Room Type</th>
                        <th>Floor</th>
                        <th>Status</th>
                        <th width="160">Action</th>
                    </tr>

                </thead>

                <tbody>

                @forelse($rooms as $room)

                    <tr>

                        <td>{{ $rooms->firstItem() + $loop->index }}</td>

                        <td>
                            @if(request()->filled('search'))
                                {!! preg_replace(
                                    '/('.preg_quote(e(request('search')), '/').')/i',
                                    '<mark class="user-search-match">$1</mark>',
                                    e($room->room_number)
                                ) !!}
                            @else
                                {{ $room->room_number }}
                            @endif
                        </td>

                        <td>
                            @if(request()->filled('search'))
                                {!! preg_replace(
                                    '/('.preg_quote(e(request('search')), '/').')/i',
                                    '<mark class="user-search-match">$1</mark>',
                                    e(optional($room->roomType)->name)
                                ) !!}
                            @else
                                {{ optional($room->roomType)->name }}
                            @endif
                        </td>

                        <td>{{ $room->floor }}</td>

                        <td>

                            @if($room->status == 'available')

                                <span class="badge badge-success">
                                    Available
                                </span>

                            @elseif($room->status == 'occupied')

                                <span class="badge badge-danger">
                                    Occupied
                                </span>

                            @else

                                <span class="badge badge-warning">
                                    Maintenance
                                </span>

                            @endif

                        </td>

                        <td>

                            <a href="{{ route('admin.rooms.edit',$room->id) }}"
                               class="btn btn-sm btn-info">
                                <i class="fas fa-edit"></i>
                            </a>

                            <form action="{{ route('admin.rooms.destroy',$room->id) }}"
                                  method="POST"
                                  class="d-inline">

                                @csrf
                                @method('DELETE')

                                <button
                                    class="btn btn-sm btn-danger"
                                    onclick="return confirm('Delete this room?')">

                                    <i class="fas fa-trash"></i>

                                </button>

                            </form>

                        </td>

                    </tr>

                @empty

                    <tr>

                        <td colspan="6" class="text-center">
                            {{ request()->filled('search') ? 'Not Found' : 'No Rooms Found.' }}
                        </td>

                    </tr>

                @endforelse

                </tbody>

            </table>


        </div>

    </div>

</div>
@if ($rooms->hasPages())
    <div class="d-flex justify-content-between align-items-center mt-3">
        <p class="mb-0 text-muted">
            Showing {{ $rooms->firstItem() }} to {{ $rooms->lastItem() }}
            of {{ $rooms->total() }} results
        </p>

        {{ $rooms->links() }}
    </div>
@endif

@endsection

@push('after-scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const searchInput = document.getElementById('room-search');
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