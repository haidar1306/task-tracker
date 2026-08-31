@extends('backend.layouts.app')

@section('title', 'Payments')

@section('content')

    <div class="card shadow">

        <div class="card-header d-flex justify-content-between">

            <h5>Payments</h5>

            <a href="{{ route('admin.payments.create') }}" class="btn btn-primary">
                Add Payment
            </a>

        </div>

        <div class="card-body">

            @include('includes.partials.messages')


            <form method="GET" action="{{ route('admin.payments.index') }}" class="admin-table-search-form mb-4">
                <div class="input-group">
                    <input id="room-search" type="search" name="search" value="{{ request('search') }}" class="form-control"
                        placeholder="Search payment...">

                    <div class="input-group-append">
                        <button type="submit" class="btn btn-primary">Search</button>

                        @if(request()->filled('search'))
                            <a href="{{ route('admin.payments.index') }}" class="btn btn-secondary">Clear</a>
                        @endif
                    </div>
                </div>
            </form>

            <table class="table table-bordered">

                <thead>

                    <tr>

                        <th>#</th>
                        <th>Booking No</th>
                        <th>Date</th>
                        <th>Amount</th>
                        <th>Method</th>
                        <th>Status</th>
                        <th>Action</th>

                    </tr>

                </thead>

                <tbody>

                    @forelse($payments as $payment)

                        <tr>

                            <td>{{ $payments->firstItem() + $loop->index }}</td>

                            <td>
                                {{ optional($payment->invoice)->invoice_no }}
                            </td>
                            <!-- <td>
                                        {{ optional($payment->invoice)->invoice_no }}
                                    </td> -->


                            <td>{{ $payment->payment_date->format('d-m-Y') }}</td>

                            <td>{{ $payment->amount }}</td>

                            <td>{{ $payment->payment_method }}</td>

                            <td>{{ $payment->payment_status }}</td>

                            <td>

                                <a href="{{ route('admin.payments.edit', $payment) }}" class="btn btn-info btn-sm">

                                    Edit

                                </a>

                                <form action="{{ route('admin.payments.destroy', $payment) }}" method="POST" class="d-inline">

                                    @csrf
                                    @method('DELETE')

                                    <button class="btn btn-danger btn-sm" onclick="return confirm('Delete Payment?')">

                                        Delete

                                    </button>

                                </form>

                            </td>

                        </tr>

                    @empty

                        <tr>

                            <td colspan="7" class="text-center">

                                No Payments Found

                            </td>

                        </tr>

                    @endforelse

                </tbody>

            </table>

            @if ($payments->hasPages())
                <div class="d-flex justify-content-between align-items-center mt-3">
                    <p class="mb-0 text-muted">
                        Showing {{ $payments->firstItem() }} to {{ $payments->lastItem() }}
                        of {{ $payments->total() }} results
                    </p>

                    {{ $payments->links() }}
                </div>
            @endif

        </div>

    </div>

@endsection