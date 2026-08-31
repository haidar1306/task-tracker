@extends('backend.layouts.app')

@section('title', 'Create Room')

@section('content')

<div class="card shadow mb-4">

    <div class="card-header py-3 d-flex justify-content-between align-items-center">
        <h6 class="m-0 font-weight-bold text-primary">
            Create Room
        </h6>

        <a href="{{ route('admin.rooms.index') }}" class="btn btn-secondary btn-sm">
            <i class="fas fa-arrow-left"></i> Back
        </a>
    </div>

    <div class="card-body">

        <form action="{{ route('admin.rooms.store') }}" method="POST">

            @csrf

            @include('backend.rooms.form')

        </form>

    </div>

</div>

@endsection