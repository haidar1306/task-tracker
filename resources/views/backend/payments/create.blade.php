@extends('backend.layouts.app')

@section('title','Create Payment')

@section('content')

<div class="card shadow">

    <div class="card-header">

        <h5>Create Payment</h5>

    </div>

    <div class="card-body">

        <form action="{{ route('admin.payments.store') }}"
              method="POST">

            @csrf

            @include('backend.payments.form')

        </form>

    </div>

</div>

@endsection