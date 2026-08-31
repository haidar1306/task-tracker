<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StorePaymentRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            // 'booking_id' => 'required|exists:bookings,id',
            'payment_date' => 'required|date',
            'amount' => 'required|numeric|min:0',
            'payment_method' => 'required|in:Cash,Card,UPI,Bank Transfer',
            'transaction_id' => 'nullable|string|max:100',
            'payment_status' => 'required|in:Pending,Paid,Failed,Refunded',
            'remarks' => 'nullable|string',
            'status' => 'required|boolean',
            'invoice_id' => 'required'
        ];
    }
}