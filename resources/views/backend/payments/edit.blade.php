@extends('backend.layouts.app')

@section('title', 'Edit Payment')

@section('content')

    <div class="card shadow">

        <div class="card-header">

            <h5>Edit Payment</h5>

        </div>

        <div class="card-body">
    
            <form action="{{ route('admin.payments.update', $payment->id) }}" method="POST">

                @csrf
                @method('PUT')

                @include('backend.payments.form')

            </form>

        </div>

    </div>

@endsection