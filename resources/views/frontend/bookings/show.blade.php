<!-- @extends('frontend.layouts.app')

@section('content')

    <div class="container py-5">

        <h2>
            Invoice Details
        </h2>


        <div class="card shadow p-4">

            <h4>
                Invoice No:
                {{ $invoice->invoice_no }}
            </h4>


            <p>
                Booking ID:
                {{ $invoice->booking_id }}
            </p>


            <p>
                Room Charge:
                ₹{{ $invoice->room_charge }}
            </p>


            <p>
                Extra Charge:
                ₹{{ $invoice->extra_charge }}
            </p>


            <p>
                Tax:
                ₹{{ $invoice->tax }}
            </p>


            <p>
                Discount:
                ₹{{ $invoice->discount }}
            </p>


            <h3>
                Total:
                ₹{{ $invoice->total_amount }}
            </h3>

            <p>
                Payment Status :

                @if($invoice->payment_status == 'Paid')
                    <span class="badge badge-success">Paid</span>

                @elseif($invoice->payment_status == 'Partial')
                    <span class="badge badge-warning">Partial</span>

                @else
                    <span class="badge badge-danger">Pending</span>
                @endif

            </p>
            <p>
                Paid Amount :
                ₹{{ number_format($invoice->paid_amount, 2) }}
            </p>

            <p>
                Remaining Amount :
                ₹{{ number_format($invoice->total_amount - $invoice->paid_amount, 2) }}
            </p>


        </div>


    </div>
    <hr>

    <h4>
        Payment History
    </h4>

    <table class="table">

        <tr>
            <th>Date</th>
            <th>Method</th>
            <th>Amount</th>
            <th>Status</th>
        </tr>


        @foreach($invoice->payments as $payment)

            <tr>

                <td>
                    {{ $payment->payment_date }}
                </td>

                <td>
                    {{ $payment->payment_method }}
                </td>

                <td>
                    ₹{{ $payment->amount }}
                </td>

                <td>
                    <span class="badge badge-success">
                        {{ $payment->payment_status }}
                    </span>
                </td>

            </tr>

        @endforeach


    </table>

@endsection -->