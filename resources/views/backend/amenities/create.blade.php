@extends('backend.layouts.app')

@section('title','Create Amenity')

@section('content')

<div class="card shadow">

    <div class="card-header d-flex justify-content-between">

        <h5>Create Amenity</h5>

        <a href="{{ route('admin.amenities.index') }}"
           class="btn btn-secondary btn-sm">

            Back

        </a>

    </div>

    <div class="card-body">

        <form action="{{ route('admin.amenities.store') }}" method="POST">

            @csrf

            @include('backend.amenities.form')

        </form>

    </div>

</div>

@endsection