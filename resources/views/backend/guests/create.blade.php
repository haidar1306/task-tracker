@extends('backend.layouts.app')

@section('title','Create Guest')

@section('content')

<div class="card shadow">

    <div class="card-header">

        <h5>Create Guest</h5>

    </div>

    <div class="card-body">

        <form action="{{ route('admin.guests.store') }}" method="POST">

            @csrf

            @include('backend.guests.form')

        </form>

    </div>

</div>

@endsection