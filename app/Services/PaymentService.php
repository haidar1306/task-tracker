<?php

namespace App\Services;
use App\Models\Invoice;

use App\Models\Payment;
use Illuminate\Support\Facades\DB;

class PaymentService
{
   public function all($perPage = false)
   {
       $query = Payment::with('invoice.booking')->latest();

       if (is_numeric($perPage)) {
           return $query->paginate($perPage);
       }

       return $query->get();
   }

public function store(array $data): Payment
{
    return DB::transaction(function () use ($data) {

        $payment = Payment::create($data);


        if($payment->invoice_id)
        {
            $invoice = \App\Models\Invoice::find($payment->invoice_id);


            $paidAmount = $invoice->payments()->sum('amount');


            $invoice->update([
                'paid_amount' => $paidAmount,

                'payment_status' => 
                    $paidAmount >= $invoice->total_amount
                    ? 'Paid'
                    : 'Pending'
            ]);
        }


        return $payment;

    });
}
    public function update(Payment $payment, array $data): Payment
    {   
        DB::transaction(function () use ($payment, $data) {

            $payment->update($data);

        });

        return $payment;
    }

    public function delete(Payment $payment)
    {
        return DB::transaction(function () use ($payment) {

            return $payment->delete();

        });
    }
}