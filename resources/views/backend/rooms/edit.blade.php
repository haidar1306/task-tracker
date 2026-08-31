@extends('backend.layouts.app')

@section('title', 'Edit Room')

@section('content')

<div class="card shadow mb-4">

    <div class="card-header py-3 d-flex justify-content-between align-items-center">
        <h6 class="m-0 font-weight-bold text-primary">
            Edit Room
        </h6>

        <a href="{{ route('admin.rooms.index') }}" class="btn btn-secondary btn-sm">
            <i class="fas fa-arrow-left"></i> Back
        </a>
    </div>

    <div class="card-body">
        

        <form action="{{ route('admin.rooms.update',$room->id) }}" method="POST">

            @csrf
            @method('PUT')

            @include('backend.rooms.form')

        </form>

    </div>

</div>

@endsection