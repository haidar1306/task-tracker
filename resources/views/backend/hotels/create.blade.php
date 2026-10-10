@extends('backend.layouts.app')

@section('title', 'Add Hotel')

@section('content')

<div class="container-fluid">

    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 mb-0 text-gray-800">
            Add Hotel
        </h1>

        <a href="{{ route('admin.hotels.index') }}"
           class="btn btn-secondary">
            Back
        </a>
    </div>


    <div class="card shadow-sm">
        <div class="card-body">

            <form
                action="{{ route('admin.hotels.store') }}"
                method="POST"
            >

                @include('backend.hotels.form')

            </form>

        </div>
    </div>

</div>

@endsection