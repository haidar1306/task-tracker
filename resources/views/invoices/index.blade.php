@extends('backend.layouts.app')

@section('title','Invoices')

@section('content')

<div class="card shadow mb-4">

<div class="card-header d-flex justify-content-between">

<h6 class="font-weight-bold text-primary">
Invoice Management
</h6>


<a href="{{ route('admin.invoices.create') }}"
class="btn btn-primary btn-sm">

<i class="fas fa-plus"></i>
Create Invoice

</a>

</div>


<div class="card-body">


<table class="table table-bordered">

<thead>

<tr>

<th>#</th>
<th>Invoice No</th>
<th>Booking</th>
<th>Amount</th>
<th>Payment</th>
<th>Action</th>

</tr>

</thead>


<tbody>


@forelse($invoices as $invoice)


<tr>

<td>{{ $invoices->firstItem() + $loop->index }}</td>


<td>
{{ $invoice->invoice_no }}
</td>


<td>
{{ $invoice->booking->booking_no ?? '-' }}
</td>


<td>
₹ {{ number_format($invoice->total_amount,2) }}
</td>


<td>

<span class="badge badge-warning">

{{ $invoice->payment_status }}

</span>

</td>


<td>


<a href="{{ route('admin.invoices.show',$invoice->id) }}"
class="btn btn-info btn-sm">

<i class="fas fa-eye"></i>

</a>


</td>


</tr>


@empty


<tr>

<td colspan="6" class="text-center">

No Invoice Found

</td>

</tr>


@endforelse


</tbody>


</table>

@if ($invoices->hasPages())
	<div class="d-flex justify-content-between align-items-center mt-3">
		<p class="mb-0 text-muted">
			Showing {{ $invoices->firstItem() }} to {{ $invoices->lastItem() }}
			of {{ $invoices->total() }} results
		</p>

		{{ $invoices->links() }}
	</div>
@endif


</div>

</div>


@endsection