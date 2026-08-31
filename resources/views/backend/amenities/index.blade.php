@extends('backend.layouts.app')

@section('title', 'Amenities')

@section('content')

    <div class="card shadow mb-4">

        <div class="card-header py-3 d-flex justify-content-between align-items-center">

            <h6 class="m-0 font-weight-bold text-primary">
                Amenities
            </h6>

            <a href="{{ route('admin.amenities.create') }}" class="btn btn-primary btn-sm">
                <i class="fas fa-plus"></i> Add Amenity
            </a>

        </div>

        <div class="card-body">

            @include('includes.partials.messages')

            <form method="GET" action="{{ route('admin.amenities.index') }}" class="admin-table-search-form mb-4">
                <div class="input-group">
                    <input id="amenity-search" type="search" name="search" value="{{ request('search') }}"
                           class="form-control" placeholder="Search amenity...">

                    <div class="input-group-append">
                        <button type="submit" class="btn btn-primary">Search</button>

                        @if(request()->filled('search'))
                            <a href="{{ route('admin.amenities.index') }}" class="btn btn-secondary">Clear</a>
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
                            <th>Description</th>
                            <th>Status</th>
                            <th width="150">Action</th>
                        </tr>

                    </thead>

                    <tbody>

                        @forelse($amenities as $amenity)

                            <tr>

                                <td>{{ $amenities->firstItem() + $loop->index }}</td>

                                <td>
                                    @if(request()->filled('search'))
                                        {!! preg_replace(
                                            '/('.preg_quote(e(request('search')), '/').')/i',
                                            '<mark class="user-search-match">$1</mark>',
                                            e($amenity->name)
                                        ) !!}
                                    @else
                                        {{ $amenity->name }}
                                    @endif
                                </td>

                                <td>
                                    @if(request()->filled('search'))
                                        {!! preg_replace(
                                            '/('.preg_quote(e(request('search')), '/').')/i',
                                            '<mark class="user-search-match">$1</mark>',
                                            e($amenity->description)
                                        ) !!}
                                    @else
                                        {{ $amenity->description }}
                                    @endif
                                </td>

                                <td>

                                    @if($amenity->status)

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

                                    <a href="{{ route('admin.amenities.edit', $amenity->id) }}" class="btn btn-info btn-sm">

                                        <i class="fas fa-edit"></i>

                                    </a>

                                    <form action="{{ route('admin.amenities.destroy', $amenity->id) }}" method="POST"
                                        class="d-inline">

                                        @csrf
                                        @method('DELETE')

                                        <button class="btn btn-danger btn-sm" onclick="return confirm('Delete this Amenity?')">

                                            <i class="fas fa-trash"></i>

                                        </button>

                                    </form>

                                </td>

                            </tr>

                        @empty

                            <tr>

                                <td colspan="5" class="text-center">

                                    {{ request()->filled('search') ? 'Not Found' : 'No Amenities Found.' }}

                                </td>

                            </tr>

                        @endforelse

                    </tbody>

                </table>

            </div>

        </div>
    </div>
   @if ($amenities->hasPages())
    <div class="d-flex justify-content-between align-items-center mt-3">
        <p class="mb-0 text-muted">
            Showing {{ $amenities->firstItem() }} to {{ $amenities->lastItem() }}
            of {{ $amenities->total() }} results
        </p>

        {{ $amenities->links() }}
    </div>
@endif

@push('after-scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const searchInput = document.getElementById('amenity-search');
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