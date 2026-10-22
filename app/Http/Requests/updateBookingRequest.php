<?php

namespace App\Http\Requests;

use App\Domains\Auth\Models\User;
use App\Models\Booking;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

/**
 * Status yahan se nahi badalta (sirf action buttons se).
 * Stay fields `sometimes` hain: Checked In / Out booking me wo disabled aate hain.
 */
class UpdateBookingRequest extends FormRequest
{
    public function authorize()
    {
        return $this->user() && $this->user()->type === User::TYPE_ADMIN;
    }

    public function rules()
    {
        return [
            'guest_id'       => ['sometimes', 'required', 'integer', 'exists:guests,id'],
            'room_id'        => ['sometimes', 'required', 'integer', 'exists:rooms,id'],
            'check_in'       => ['sometimes', 'required', 'date_format:Y-m-d'],
            'check_out'      => ['sometimes', 'required', 'date_format:Y-m-d', 'after:check_in'],
            'adults'         => ['sometimes', 'required', 'integer', 'min:1', 'max:20'],
            'children'       => ['nullable', 'integer', 'min:0', 'max:20'],
            'payment_status' => ['required', Rule::in(Booking::PAYMENT_STATUSES)],
            'remarks'        => ['nullable', 'string', 'max:1000'],
            'status'         => ['required', 'boolean'],
        ];
    }
}