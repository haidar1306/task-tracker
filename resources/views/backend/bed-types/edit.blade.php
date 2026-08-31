@extends('backend.layouts.app')

@section('title', 'Edit Bed Type')

@section('content')

    <div class="card shadow">

        <div class="card-header d-flex justify-content-between">

            <h5>Edit Bed Type</h5>

            <a href="{{ route('admin.bed-types.index') }}" class="btn btn-secondary btn-sm">

                Back

            </a>

        </div>

        <div class="card-body">

            <form action="{{ route('admin.bed-types.update', $bedType->id) }}" method="POST">

                @csrf
                @method('PUT')

                @include('backend.bed-types.form')

            </form>

        </div>

    </div>

@endsection