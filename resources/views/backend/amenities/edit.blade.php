@extends('backend.layouts.app')

@section('title','Edit Amenity')

@section('content')

<div class="card shadow">

    <div class="card-header d-flex justify-content-between">

        <h5>Edit Amenity</h5>

        <a href="{{ route('admin.amenities.index') }}"
           class="btn btn-secondary btn-sm">

            Back

        </a>

    </div>

    <div class="card-body">

        <form action="{{ route('admin.amenities.update',$amenity->id) }}"
              method="POST">

            @csrf
            @method('PUT')

            @include('backend.amenities.form')

        </form>

    </div>

</div>

@endsection