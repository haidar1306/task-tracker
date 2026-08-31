@extends('backend.layouts.app')

@section('title','Create Bed Type')

@section('content')

<div class="card shadow">

    <div class="card-header d-flex justify-content-between">

        <h5>Create Bed Type</h5>

        <a href="{{ route('admin.bed-types.index') }}"
            class="btn btn-secondary btn-sm">

            Back

        </a>

    </div>

    <div class="card-body">

        <form action="{{ route('admin.bed-types.store') }}" method="POST">

            @csrf

            @include('backend.bed-types.form')

        </form>

    </div>

</div>

@endsection