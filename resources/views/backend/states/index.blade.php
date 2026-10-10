@extends('backend.layouts.app')

@section('content')

    <div class="container-fluid">

        <div class="d-flex justify-content-between align-items-center mb-4">
            <h3>States</h3>

            <a href="{{ route('admin.states.create') }}" class="btn btn-primary">
                Add State
            </a>
        </div>

        @if(session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        <div class="card">
            <div class="card-body">

                <!-- <div class="table-responsive">
                    <table class="table table-bordered table-hover align-middle">

                        <thead>
                            <tr>
                                <th>#</th>
                                <th>State Name</th>
                                <th>Country</th>
                                <th width="180">Action</th>
                            </tr>
                        </thead>

                        <tbody>
                            @forelse($states as $state)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>

                                    <td>{{ $state->name }}</td>

                                    <td>
                                        {{ $state->country->name ?? 'N/A' }}
                                    </td>

                                    <td>
                                        <a href="{{ route('admin.states.edit', $state) }}" class="btn btn-sm btn-warning">
                                            Edit
                                        </a>

                                        <form action="{{ route('admin.states.destroy', $state) }}" method="POST"
                                            class="d-inline">

                                            @csrf
                                            @method('DELETE')

                                            <button type="submit" class="btn btn-sm btn-danger"
                                                onclick="return confirm('Are you sure you want to delete this state?')">
                                                Delete
                                            </button>

                                        </form>
                                    </td>
                                </tr>

                            @empty

                                <tr>
                                    <td colspan="4" class="text-center">
                                        No states found.
                                    </td>
                                </tr>

                            @endforelse
                        </tbody>

                    </table>
                </div> -->
                  <div>
               <livewire:backend.states-table />
</div>

            </div>
        </div>

    </div>

@endsection

