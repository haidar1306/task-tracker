@extends('backend.layouts.app')

@section('content')

<div class="container-fluid">

    <div class="d-flex justify-content-between align-items-center mb-4">
        <h3>Edit City</h3>

        <a href="{{ route('admin.cities.index') }}" class="btn btn-secondary">
            Back
        </a>
    </div>

    <div class="card">
        <div class="card-body">

            <form action="{{ route('admin.cities.update', $city) }}" method="POST">
                @csrf
                @method('PUT')

                @include('backend.cities.form')

                <button type="submit" class="btn btn-primary">
                    Update City
                </button>

                <a href="{{ route('admin.cities.index') }}" class="btn btn-secondary">
                    Cancel
                </a>
            </form>

        </div>
    </div>

</div>

@endsection