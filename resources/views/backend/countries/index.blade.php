@extends('backend.layouts.app')

@section('title', 'countries')

@section('content')
    @include('includes.partials.messages')


    <div class="container-fluid">

        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2>Countries</h2>

            <a href="{{ route('admin.countries.create') }}" class="btn btn-primary">
                Add Country
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
                                <th width="80">#</th>
                                <th>Country Name</th>
                                <th>ISO</th>
                                <th width="180">Action</th>
                            </tr>
                        </thead>

                        <tbody>
                            @forelse($countries as $country)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>

                                    <td>{{ $country->name }}</td>

                                    <td>
                                        <span>
                                            {{ $country->iso }}
                                        </span>
                                    </td>
                                    <td>
                                        <a href="{{ route('admin.countries.edit', $country) }}" class="btn btn-sm btn-warning">
                                            Edit
                                        </a>

                                        <form action="{{ route('admin.countries.destroy', $country) }}" method="POST"
                                            class="d-inline">
                                            @csrf
                                            @method('DELETE')

                                            <button type="submit" class="btn btn-sm btn-danger"
                                                onclick="return confirm('Are you sure you want to delete this country?')">
                                                Delete
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="text-center">
                                        No countries found.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div> -->
                <div>
               <livewire:backend.countries-table />
</div>
            </div>
        </div>

        
    </div>
@endsection