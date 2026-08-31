@extends('backend.layouts.app')

@section('title','Edit Guest')

@section('content')

<div class="card shadow">

    <div class="card-header">

        <h5>Edit Guest</h5>

    </div>

    <div class="card-body">

        <form action="{{ route('admin.guests.update',$guest->id) }}" method="POST">

            @csrf
            @method('PUT')

            @include('backend.guests.form')

        </form>

    </div>

</div>

@endsection