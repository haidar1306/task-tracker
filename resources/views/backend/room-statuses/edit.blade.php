@extends('backend.layouts.app')

@section('title','Edit Room Status')

@section('content')

<div class="card shadow">

    <div class="card-header d-flex justify-content-between">

        <h5>Edit Room Status</h5>

        <a href="{{ route('admin.room-statuses.index') }}"
           class="btn btn-secondary btn-sm">

            Back

        </a>

    </div>

    <div class="card-body">

        <form action="{{ route('admin.room-statuses.update',$roomStatus->id) }}"
              method="POST">

            @csrf
            @method('PUT')

            @include('backend.room-statuses.form')

        </form>

    </div>

</div>

@endsection