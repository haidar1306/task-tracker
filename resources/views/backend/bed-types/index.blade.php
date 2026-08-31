@extends('backend.layouts.app')

@section('title', 'Bed Types')

@section('content')

<div class="card shadow mb-4">

    <div class="card-header py-3 d-flex justify-content-between align-items-center">

        <h6 class="m-0 font-weight-bold text-primary">
            Bed Types
        </h6>

        <a href="{{ route('admin.bed-types.create') }}" class="btn btn-primary btn-sm">
            <i class="fas fa-plus"></i> Add Bed Type
        </a>

    </div>

    <div class="card-body">

        @include('includes.partials.messages')

        <form method="GET" action="{{ route('admin.bed-types.index') }}" class="admin-table-search-form mb-4">
            <div class="input-group">
                <input id="bed-type-search" type="search" name="search" value="{{ request('search') }}"
                       class="form-control" placeholder="Search bed type...">

                <div class="input-group-append">
                    <button type="submit" class="btn btn-primary">Search</button>

                    @if(request()->filled('search'))
                        <a href="{{ route('admin.bed-types.index') }}" class="btn btn-secondary">Clear</a>
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

                    @forelse($bedTypes as $bedType)

                    <tr>

                        <td>{{ $bedTypes->firstItem() + $loop->index }}</td>

                        <td>
                            @if(request()->filled('search'))
                                {!! preg_replace(
                                    '/('.preg_quote(e(request('search')), '/').')/i',
                                    '<mark class="user-search-match">$1</mark>',
                                    e($bedType->name)
                                ) !!}
                            @else
                                {{ $bedType->name }}
                            @endif
                        </td>

                        <td>
                            @if(request()->filled('search'))
                                {!! preg_replace(
                                    '/('.preg_quote(e(request('search')), '/').')/i',
                                    '<mark class="user-search-match">$1</mark>',
                                    e($bedType->description)
                                ) !!}
                            @else
                                {{ $bedType->description }}
                            @endif
                        </td>

                        <td>

                            @if($bedType->status)
                                <span class="badge badge-success">Active</span>
                            @else
                                <span class="badge badge-danger">Inactive</span>
                            @endif

                        </td>

                        <td>

                            <a href="{{ route('admin.bed-types.edit',$bedType->id) }}"
                                class="btn btn-info btn-sm">

                                <i class="fas fa-edit"></i>

                            </a>

                            <form action="{{ route('admin.bed-types.destroy',$bedType->id) }}"
                                method="POST"
                                class="d-inline">

                                @csrf
                                @method('DELETE')

                                <button class="btn btn-danger btn-sm"
                                    onclick="return confirm('Delete this Bed Type?')">

                                    <i class="fas fa-trash"></i>

                                </button>

                            </form>

                        </td>

                    </tr>

                    @empty

                    <tr>

                        <td colspan="5" class="text-center">
                            {{ request()->filled('search') ? 'Not Found' : 'No Bed Types Found.' }}
                        </td>

                    </tr>

                    @endforelse

                </tbody>

            </table>

        </div>

    </div>

</div>
@if ($bedTypes->hasPages())
    <div class="d-flex justify-content-between align-items-center mt-3">
        <p class="mb-0 text-muted">
            Showing {{ $bedTypes->firstItem() }} to {{ $bedTypes->lastItem() }}
            of {{ $bedTypes->total() }} results
        </p>

        {{ $bedTypes->links() }}
    </div>
@endif

@push('after-scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const searchInput = document.getElementById('bed-type-search');
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