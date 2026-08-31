@extends('backend.layouts.app')

@section('title', 'Edit Room Type')

@section('content')

    <div class="card shadow mb-4">

        <div class="card-header py-3 d-flex justify-content-between align-items-center">
            <h6 class="m-0 font-weight-bold text-primary">
                Edit Room Type
            </h6>

            <a href="{{ route('admin.room-types.index') }}" class="btn btn-sm btn-secondary">
                <i class="fas fa-arrow-left"></i> Back
            </a>
        </div>

        <div class="card-body">

            <form method="POST" action="{{ route('admin.room-types.update', $roomType) }}" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                @include('backend.room-type.form')

            </form>

        </div>

    </div>

@endsection