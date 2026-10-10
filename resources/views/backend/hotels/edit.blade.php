@extends('backend.layouts.app')

@section('title', 'Edit Hotel')

@section('content')

<div class="container-fluid">

    <div class="d-flex justify-content-between align-items-center mb-4">

        <h1 class="h3 mb-0 text-gray-800">
            Edit Hotel
        </h1>

        <a href="{{ route('admin.hotels.index') }}"
           class="btn btn-secondary">
            Back
        </a>

    </div>


    <div class="card shadow-sm">
        <div class="card-body">

            <form
                action="{{ route('admin.hotels.update', $hotel->id) }}"
                method="POST"
            >

                @method('PUT')

                @include('backend.hotels.form')

            </form>

        </div>
    </div>

</div>

@endsection