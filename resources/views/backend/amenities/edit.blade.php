@extends('backend.layouts.app')

@section('title', 'Edit Amenity')

@section('content')
<div class="container-fluid px-0">

    <div class="card shadow-sm border-0">

        <div class="card-header bg-white d-flex justify-content-between align-items-center py-3">
            <h5 class="mb-0">Edit Amenity</h5>

            <a href="{{ route('admin.amenities.index') }}"
               class="btn btn-secondary btn-sm">
                <i class="fas fa-arrow-left me-1"></i> Back
            </a>
        </div>

        <div class="card-body p-4">

            <form action="{{ route('admin.amenities.update', $amenity->id) }}"
                  method="POST"
                  enctype="multipart/form-data">

                @csrf
                @method('PUT')

                @include('backend.amenities.form', [
                    'amenity' => $amenity
                ])

            </form>

        </div>
    </div>

</div>
@endsection