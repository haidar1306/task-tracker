<?php

namespace App\Http\Requests;

use App\Domains\Auth\Models\User;
use App\Models\Booking;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreBookingRequest extends FormRequest
{
    public function authorize()
    {
        return $this->user() && $this->user()->type === User::TYPE_ADMIN;
    }

    public function rules()
    {
        return [
            'guest_id'       => ['required', 'integer', 'exists:guests,id'],
            'room_id'        => ['required', 'integer', 'exists:rooms,id'],
            'check_in'       => ['required', 'date_format:Y-m-d', 'after_or_equal:today'],
            'check_out'      => ['required', 'date_format:Y-m-d', 'after:check_in'],
            'adults'         => ['required', 'integer', 'min:1', 'max:20'],
            'children'       => ['nullable', 'integer', 'min:0', 'max:20'],
            'booking_status' => ['required', Rule::in([Booking::STATUS_PENDING, Booking::STATUS_CONFIRMED])],
            'payment_status' => ['required', Rule::in(Booking::PAYMENT_STATUSES)],
            'remarks'        => ['nullable', 'string', 'max:1000'],
            'status'         => ['required', 'boolean'],
        ];
    }
}