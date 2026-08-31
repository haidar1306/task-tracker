@extends('backend.layouts.app')

@section('title', 'Services')

@section('content')
<div class="container-fluid">

    <div class="d-flex justify-content-between align-items-center mb-3">
        <h4 class="mb-0">Services</h4>

        <a href="{{ route('admin.services.create') }}" class="btn btn-primary">
            <i class="fas fa-plus"></i> Add Service
        </a>
    </div>

    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <div class="card shadow-sm">
        <div class="card-body">

            <div class="table-responsive">

                <table class="table table-bordered table-hover align-middle">

                    <thead class="table-dark">
                        <tr>
                            <th width="60">#</th>
                            <th width="90">Image</th>
                            <th>Title</th>
                            <th>Icon</th>
                            <th>Status</th>
                            <th>Order</th>
                            <th width="180">Action</th>
                        </tr>
                    </thead>

                    <tbody>

                    @forelse($services as $key => $service)

                        <tr>

                            <td>{{ $loop->iteration }}</td>

                            <td>

                                @if($service->image)

                                    <img src="{{ asset('uploads/services/'.$service->image) }}"
                                         width="70"
                                         class="rounded">

                                @else

                                    <span class="text-muted">No Image</span>

                                @endif

                            </td>

                            <td>{{ $service->title }}</td>

                            <td>

                                @if($service->icon)
                                    <i class="{{ $service->icon }}"></i>
                                    {{ $service->icon }}
                                @endif

                            </td>

                            <td>

                                @if($service->status)

                                    <span class="badge bg-success">
                                        Active
                                    </span>

                                @else

                                    <span class="badge bg-danger">
                                        Inactive
                                    </span>

                                @endif

                            </td>

                            <td>{{ $service->sort_order }}</td>

                            <td>

                                <a href="{{ route('admin.services.edit',$service->id) }}"
                                   class="btn btn-sm btn-warning">

                                    <i class="fas fa-edit"></i>

                                </a>

                                <form action="{{ route('admin.services.destroy',$service->id) }}"
                                      method="POST"
                                      class="d-inline">

                                    @csrf
                                    @method('DELETE')

                                    <button
                                        class="btn btn-sm btn-danger"
                                        onclick="return confirm('Delete this service?')">

                                        <i class="fas fa-trash"></i>

                                    </button>

                                </form>

                            </td>

                        </tr>

                    @empty

                        <tr>

                            <td colspan="7" class="text-center">

                                No Services Found

                            </td>

                        </tr>

                    @endforelse

                    </tbody>

                </table>

            </div>

            <div class="mt-3">
                {{ $services->links() }}
            </div>

        </div>
    </div>

</div>
@endsection