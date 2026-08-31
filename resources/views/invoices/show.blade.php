@extends('backend.layouts.app')

@section('title','Invoice Details')


@section('content')


<div class="card shadow">


<div class="card-header">

<h6 class="font-weight-bold text-primary">

Invoice Details

</h6>

</div>



<div class="card-body">


<h5>
Invoice No :
{{ $invoice->invoice_no }}
</h5>


<p>
Booking :
{{ $invoice->booking->booking_no }}
</p>


<p>
Room Charge :
₹ {{ $invoice->room_charge }}
</p>


<p>
Extra Charge :
₹ {{ $invoice->extra_charge }}
</p>


<p>
Tax :
₹ {{ $invoice->tax }}
</p>


<p>
Discount :
₹ {{ $invoice->discount }}
</p>


<hr>


<h4>

Total :
₹ {{ number_format($invoice->total_amount,2) }}

</h4>



<p>

Payment Status :

<span class="badge badge-warning">

{{ $invoice->payment_status }}

</span>

</p>
<p>
    Paid Amount : ₹ {{ number_format($invoice->payments->sum('amount'),2) }}
</p>




</div>


</div>


@endsection