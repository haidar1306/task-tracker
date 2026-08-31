@extends('backend.layouts.app')

@section('title','Guests')

@section('content')
<!-- @include('includes.partials.messages') -->

<div class="card shadow mb-4">

    <div class="card-header py-3 d-flex justify-content-between">

        <h6 class="m-0 font-weight-bold text-primary">
            Guest Management
        </h6>

        <a href="{{ route('admin.guests.create') }}" class="btn btn-primary btn-sm">
            <i class="fas fa-plus"></i> Add Guest
        </a>

    </div>

    <div class="card-body">
         @include('includes.partials.messages')

        <form method="GET" action="{{ route('admin.guests.index') }}" class="admin-table-search-form mb-4">
            <div class="input-group">
                <input id="guest-search" type="search" name="search" value="{{ request('search') }}"
                       class="form-control" placeholder="Search guest by name or email...">

                <div class="input-group-append">
                    <button type="submit" class="btn btn-primary">Search</button>
                </div>
            </div>

            @if(request()->filled('search'))
                <a href="{{ route('admin.guests.index') }}" class="btn btn-secondary btn-sm mt-2">Clear</a>
            @endif
        </form>

        <div class="table-responsive">

            <table class="table table-bordered table-hover">

                <thead>

                <tr>

                    <th>#</th>
                    <th>Name</th>
                    <th>Phone</th>
                    <th>Email</th>
                    <th>Gender</th>
                    <th>City</th>
                    <th>Status</th>
                    <th width="130">Action</th>

                </tr>

                </thead>

                <tbody>

                @forelse($guests as $guest)

                <tr>

                    <td>{{ $guests->firstItem() + $loop->index }}</td>

                    <td>{{ $guest->full_name }}</td>

                    <td>{{ $guest->phone }}</td>

                    <td>{{ $guest->email }}</td>

                    <td>{{ $guest->gender }}</td>

                    <td>{{ $guest->city }}</td>

                    <td>

                        @if($guest->status)

                            <span class="badge badge-success">Active</span>

                        @else

                            <span class="badge badge-danger">Inactive</span>

                        @endif

                    </td>

                    <td>

                        <a href="{{ route('admin.guests.edit',$guest) }}"
                           class="btn btn-info btn-sm">

                            <i class="fas fa-edit"></i>

                        </a>

                        <form action="{{ route('admin.guests.destroy',$guest) }}"
                              method="POST"
                              class="d-inline">

                            @csrf
                            @method('DELETE')

                            <button class="btn btn-danger btn-sm"
                                    onclick="return confirm('Delete Guest?')">

                                <i class="fas fa-trash"></i>

                            </button>

                        </form>

                    </td>

                </tr>

                @empty

                <tr>

                    <td colspan="8" class="text-center">

                        No Guests Found

                    </td>

                </tr>

                @endforelse

                </tbody>

            </table>

        </div>

    </div>

</div>

@if ($guests->hasPages())
    <div class="d-flex justify-content-between align-items-center mt-3">
        <p class="mb-0 text-muted">
            Showing {{ $guests->firstItem() }} to {{ $guests->lastItem() }}
            of {{ $guests->total() }} results
        </p>

        {{ $guests->links() }}
    </div>
@endif

@push('after-scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const searchInput = document.getElementById('guest-search');
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