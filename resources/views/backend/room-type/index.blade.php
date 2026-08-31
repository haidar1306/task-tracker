@extends('backend.layouts.app')

@section('title', 'Room Types')

@section('content')

<div class="card shadow mb-4">

    <div class="card-header py-3 d-flex justify-content-between align-items-center">
        <h6 class="m-0 font-weight-bold text-primary">
            Room Types
        </h6>

        <a href="{{ route('admin.room-types.create') }}" class="btn btn-primary btn-sm">
            <i class="fas fa-plus"></i> Add Room Type
        </a>
    </div>

    <div class="card-body">

        @include('includes.partials.messages')

        <form method="GET" action="{{ route('admin.room-types.index') }}" class="admin-table-search-form mb-4">
            <div class="input-group">
                  <input id="room-type-search" type="search" name="search" value="{{ request('search') }}"
                       class="form-control" placeholder="Search room type...">

                <div class="input-group-append">
                    <button type="submit" class="btn btn-primary">Search</button>

                    @if(request()->filled('search'))
                        <a href="{{ route('admin.room-types.index') }}" class="btn btn-secondary">
                            Clear
                        </a>
                    @endif
                </div>
            </div>
        </form>

        <div class="table-responsive">

            <table class="table table-bordered table-hover">

                <thead class="thead-dark">
                    <tr>
                        <th width="5%">#</th>
                        <th>Name</th>
                        <th>Capacity</th>
                        <th>Price</th>
                        <th>Status</th>
                        <th width="18%">Action</th>
                    </tr>
                </thead>

                <tbody>

                @forelse($roomTypes as $key => $roomType)

                    <tr>

                        <td>{{ $roomTypes->firstItem() + $key }}</td>

                        <td>
                            @if(request()->filled('search'))
                                {!! preg_replace(
                                    '/('.preg_quote(e(request('search')), '/').')/i',
                                    '<mark class="user-search-match">$1</mark>',
                                    e($roomType->name)
                                ) !!}
                            @else
                                {{ $roomType->name }}
                            @endif
                        </td>

                        <td>{{ $roomType->capacity }}</td>

                        <td>₹ {{ number_format($roomType->price,2) }}</td>

                        <td>
                            @if($roomType->status)
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

                            <a href="{{ route('admin.room-types.edit',$roomType->id) }}"
                               class="btn btn-warning btn-sm">

                                <i class="fas fa-edit"></i>

                            </a>

                            <form action="{{ route('admin.room-types.destroy',$roomType->id) }}"
                                  method="POST"
                                  class="d-inline">

                                @csrf
                                @method('DELETE')

                                <button class="btn btn-danger btn-sm"
                                        onclick="return confirm('Delete this Room Type?')">

                                    <i class="fas fa-trash"></i>

                                </button>

                            </form>

                        </td>

                    </tr>

                @empty

                    <tr>

                        <td colspan="6" class="text-center">
                            {{ request()->filled('search') ? 'Not Found' : 'No Room Types Found' }}
                        </td>

                    </tr>

                @endforelse

                </tbody>

            </table>

        </div>

    </div>

</div>
@if ($roomTypes->hasPages())
    <div class="d-flex justify-content-between align-items-center mt-3">
        <p class="mb-0 text-muted">
            Showing {{ $roomTypes->firstItem() }} to {{ $roomTypes->lastItem() }}
            of {{ $roomTypes->total() }} results
        </p>

        {{ $roomTypes->links() }}
    </div>
@endif

@endsection 

@push('after-scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const searchInput = document.getElementById('room-type-search');
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