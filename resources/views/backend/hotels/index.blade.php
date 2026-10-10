@extends('backend.layouts.app')

@section('title', 'Hotels')

@section('content')

<div class="container-fluid">

    {{-- Header --}}
    <div class="d-flex justify-content-between align-items-center mb-4">

        <div>
            <h1 class="h3 mb-1">Hotels</h1>
            <p class="text-muted mb-0">Manage hotels</p>
        </div>

        <a href="{{ route('admin.hotels.create') }}"
           class="btn btn-primary">
            <i class="fas fa-plus"></i>
            Add Hotel
        </a>

    </div>

    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <div class="card shadow-sm border-0">
        <div class="card-body">
            @livewire('backend.hotels-table')
        </div>
    </div>

</div>

@endsection