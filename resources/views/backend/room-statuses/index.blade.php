@extends('backend.layouts.app')

@section('title', 'Room Statuses')

@section('content')

<div class="card shadow mb-4">

    <div class="card-header py-3 d-flex justify-content-between align-items-center">

        <h6 class="m-0 font-weight-bold text-primary">
            Room Statuses
        </h6>

        <a href="{{ route('admin.room-statuses.create') }}" class="btn btn-primary btn-sm">
            <i class="fas fa-plus"></i> Add Room Status
        </a>

    </div>

    <div class="card-body">

        @include('includes.partials.messages')

        <form method="GET" action="{{ route('admin.room-statuses.index') }}" class="admin-table-search-form mb-4">
            <div class="input-group">
                <input id="room-status-search" type="search" name="search" value="{{ request('search') }}"
                       class="form-control" placeholder="Search room status...">

                <div class="input-group-append">
                    <button type="submit" class="btn btn-primary">Search</button>

                    @if(request()->filled('search'))
                        <a href="{{ route('admin.room-statuses.index') }}" class="btn btn-secondary">Clear</a>
                    @endif
                </div>
            </div>
        </form>

        <div class="table-responsive">

            <table class="table table-bordered table-hover">

                <thead>
                    <tr>
                        <th width="60">#</th>
                        <th>Name</th>
                        <th>Color</th>
                        <th>Description</th>
                        <th>Status</th>
                        <th width="150">Action</th>
                    </tr>
                </thead>

                <tbody>

                @forelse($roomStatuses as $roomStatus)

                    <tr>

                        <td>{{ $roomStatuses->firstItem() + $loop->index }}</td>

                        <td>
                            @if(request()->filled('search'))
                                {!! preg_replace(
                                    '/('.preg_quote(e(request('search')), '/').')/i',
                                    '<mark class="user-search-match">$1</mark>',
                                    e($roomStatus->name)
                                ) !!}
                            @else
                                {{ $roomStatus->name }}
                            @endif
                        </td>

                        <td>
                            <span class="badge badge-{{ $roomStatus->color }}">
                                @if(request()->filled('search'))
                                    {!! preg_replace(
                                        '/('.preg_quote(e(request('search')), '/').')/i',
                                        '<mark class="user-search-match">$1</mark>',
                                        e(ucfirst($roomStatus->color))
                                    ) !!}
                                @else
                                    {{ ucfirst($roomStatus->color) }}
                                @endif
                            </span>
                        </td>

                        <td>
                            @if(request()->filled('search'))
                                {!! preg_replace(
                                    '/('.preg_quote(e(request('search')), '/').')/i',
                                    '<mark class="user-search-match">$1</mark>',
                                    e($roomStatus->description)
                                ) !!}
                            @else
                                {{ $roomStatus->description }}
                            @endif
                        </td>

                        <td>

                            @if($roomStatus->status)
                                <span class="badge badge-success">Active</span>
                            @else
                                <span class="badge badge-danger">Inactive</span>
                            @endif

                        </td>

                        <td>

                            <a href="{{ route('admin.room-statuses.edit',$roomStatus->id) }}"
                               class="btn btn-info btn-sm">

                                <i class="fas fa-edit"></i>

                            </a>

                            <form action="{{ route('admin.room-statuses.destroy',$roomStatus->id) }}"
                                  method="POST"
                                  class="d-inline">

                                @csrf
                                @method('DELETE')

                                <button class="btn btn-danger btn-sm"
                                        onclick="return confirm('Delete this Room Status?')">

                                    <i class="fas fa-trash"></i>

                                </button>

                            </form>

                        </td>

                    </tr>

                @empty

                    <tr>
                        <td colspan="6" class="text-center">
                            {{ request()->filled('search') ? 'Not Found' : 'No Room Statuses Found.' }}
                        </td>
                    </tr>

                @endforelse

                </tbody>

            </table>

        </div>

    </div>

</div>
@if ($roomStatuses->hasPages())
    <div class="d-flex justify-content-between align-items-center mt-3">
        <p class="mb-0 text-muted">
            Showing {{ $roomStatuses->firstItem() }} to {{ $roomStatuses->lastItem() }}
            of {{ $roomStatuses->total() }} results
        </p>

        {{ $roomStatuses->links() }}
    </div>
@endif

@push('after-scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const searchInput = document.getElementById('room-status-search');
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

@endsection