<div class="row">

    <div class="form-group">

        <label>
            Invoice
        </label>

        <select name="invoice_id" class="form-control" required>

            <option value="">
                Select Invoice
            </option>

            @foreach($invoices as $invoice)
                <option value="{{ $invoice->id }}" data-amount="{{ $invoice->total_amount }}">
                    {{ $invoice->invoice_no }}
                    - ₹{{ number_format($invoice->total_amount, 2) }}
                </option>
            @endforeach

        </select>

    </div>
    <input type="hidden" name="booking_id" id="booking_id"><br><br>
    <!-- <div class="form-group">

<label>
Amount
</label>

<input type="number"
       name="amount"
       class="form-control"
       required>

</div> -->

    <div class="col-md-6 mb-3">

        <label>Payment Date</label>

        <input type="date" name="payment_date" class="form-control"
            value="{{ old('payment_date', isset($payment) ? $payment->payment_date->format('Y-m-d') : '') }}" required>

    </div>

    <div class="col-md-6 mb-3">

        <label>Amount</label>

        <input type="number" id="amount" name="amount" class="form-control" required>
    </div>

    <div class="col-md-6 mb-3">

        <label>Payment Method</label>

        <select name="payment_method" class="form-control">

            <option value="Cash" {{ old('payment_method', $payment->payment_method ?? '') == 'Cash' ? 'selected' : '' }}>
                Cash
            </option>

            <option value="Card" {{ old('payment_method', $payment->payment_method ?? '') == 'Card' ? 'selected' : '' }}>
                Card
            </option>

            <option value="UPI" {{ old('payment_method', $payment->payment_method ?? '') == 'UPI' ? 'selected' : '' }}>UPI
            </option>

            <option value="Bank Transfer" {{ old('payment_method', $payment->payment_method ?? '') == 'Bank Transfer' ? 'selected' : '' }}>Bank Transfer</option>

        </select>

    </div>

    <div class="col-md-6 mb-3">

        <label>Transaction ID</label>

        <input type="text" name="transaction_id" class="form-control"
            value="{{ old('transaction_id', $payment->transaction_id ?? '') }}">

    </div>

    <div class="col-md-6 mb-3">

        <label>Payment Status</label>

        <select name="payment_status" class="form-control">

            <option value="Pending" {{ old('payment_status', $payment->payment_status ?? '') == 'Pending' ? 'selected' : '' }}>
                Pending</option>

            <option value="Paid" {{ old('payment_status', $payment->payment_status ?? '') == 'Paid' ? 'selected' : '' }}>
                Paid
            </option>

            <option value="Failed" {{ old('payment_status', $payment->payment_status ?? '') == 'Failed' ? 'selected' : '' }}>
                Failed</option>

            <option value="Refunded" {{ old('payment_status', $payment->payment_status ?? '') == 'Refunded' ? 'selected' : '' }}>Refunded</option>

        </select>

    </div>

    <div class="col-md-12 mb-3">

        <label>Remarks</label>

        <textarea name="remarks" class="form-control" rows="4">{{ old('remarks', $payment->remarks ?? '') }}</textarea>

    </div>

    <div class="col-md-6 mb-3">

        <label>Status</label>

        <select name="status" class="form-control">

            <option value="1" {{ old('status', $payment->status ?? 1) == 1 ? 'selected' : '' }}>
                Active
            </option>

            <option value="0" {{ old('status', $payment->status ?? 1) == 0 ? 'selected' : '' }}>
                Inactive
            </option>

        </select>

    </div>

</div>

<hr>

<button type="submit" class="btn btn-primary">
    <i class="fas fa-save"></i>
    {{ isset($payment) ? 'Update Payment' : 'Save Payment' }}
</button>

<a href="{{ route('admin.payments.index') }}" class="btn btn-secondary">
    Cancel
</a>
<script>

document.querySelector('select[name="invoice_id"]')
.addEventListener('change', function(){

    let amount = this.options[this.selectedIndex]
    .getAttribute('data-amount');

    document.getElementById('amount').value = amount;

});

</script>