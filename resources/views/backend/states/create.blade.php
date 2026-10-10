@extends('backend.layouts.app')

@section('content')

<div class="container">
    <h3>Create State</h3>

    <form action="{{ route('admin.states.store') }}" method="POST">
        @csrf

        @include('backend.states.form')
    </form>
</div>

@endsection