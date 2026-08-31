@extends('backend.layouts.app')

@section('title','Create Invoice')

@section('content')


<div class="card shadow">

<div class="card-header">

<h6 class="font-weight-bold text-primary">
Create Invoice
</h6>

</div>


<div class="card-body">
    <!-- @if(session('error'))

<div class="alert alert-danger">
    {{ session('error') }}
</div>

@endif -->


<form method="POST"
action="{{ route('admin.invoices.store') }}">

@csrf


<div class="form-group">


<label>
Booking
</label>


<select name="booking_id"
class="form-control">


<option value="">
Select Booking
</option>


@foreach($bookings as $booking)

<option value="{{ $booking->id }}">

{{ $booking->booking_no }}

</option>


@endforeach


</select>


</div>



<div class="form-group">

<label>
Room Charge
</label>

<input type="number"
name="room_charge"
class="form-control">

</div>



<div class="form-group">

<label>
Extra Charge
</label>

<input type="number"
name="extra_charge"
class="form-control"
value="0">

</div>



<div class="form-group">

<label>
Tax
</label>

<input type="number"
name="tax"
class="form-control"
value="0">

</div>



<div class="form-group">

<label>
Discount
</label>

<input type="number"
name="discount"
class="form-control"
value="0">

</div>



<div class="form-group">

<label>
Total Amount
</label>

<input type="number"
name="total_amount"
class="form-control">

</div>



<button class="btn btn-success">

Generate Invoice

</button>


</form>


</div>

</div>


@endsection