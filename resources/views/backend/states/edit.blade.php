@extends('backend.layouts.app')

@section('content')

<div class="container">
    <h3>Edit State</h3>

    <form action="{{ route('admin.states.update', $state) }}" method="POST">
        @csrf
        @method('PUT')

        @include('backend.states.form')
    </form>
</div>

@endsection