<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreBookingRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [

            'guest_id' => 'required|exists:guests,id',

            'room_id' => 'required|exists:rooms,id',

            'check_in' => 'required|date',

            'check_out' => 'required|date|after:check_in',

            'adults' => 'required|integer|min:1',

            'children' => 'nullable|integer|min:0',

            'total_amount' => 'required|numeric',

            'booking_status' => 'required',

            'payment_status' => 'required',

            'remarks' => 'nullable',

            'status' => 'required|boolean',

        ];
    }
}