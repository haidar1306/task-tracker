@extends('backend.layouts.app')

@section('content')

    <div class="container-fluid">

        <div class="d-flex justify-content-between align-items-center mb-4">
            <h3>Cities</h3>

            <a href="{{ route('admin.cities.create') }}" class="btn btn-primary">
                Add City
            </a>
        </div>

        @if(session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        <div class="card">
            <div class="card-body">

                <livewire:backend.cities-table />

            </div>
        </div>

    </div>

@endsection