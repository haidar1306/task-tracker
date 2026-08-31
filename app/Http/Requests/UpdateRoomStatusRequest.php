<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateRoomStatusRequest extends FormRequest
{
    /**
     * Determine if the user is authorized.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Validation Rules
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name' => [
                'required',
                'max:100',
                Rule::unique('room_statuses')->ignore($this->roomStatus),
            ],

            'color' => [
                'required',
                'max:30',
            ],

            'description' => [
                'nullable',
                'max:1000',
            ],

            'status' => [
                'required',
                'boolean',
            ],
        ];
    }
}