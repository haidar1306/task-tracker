<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreRoomRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'room_number' => [
                'required',
                'max:20',
                Rule::unique('rooms'),
            ],
            'room_type_id' => [
                'required',
                'exists:room_types,id',
            ],
            'floor' => [
                'required',
                'integer',
                'min:1',
            ],
            'status' => [
                'required',
                Rule::in(['available', 'occupied', 'maintenance']),
                 ],

                'amenities' => [
                    'nullable',
                    'array',
                    // 'exists:amenities,id',
                ],

                'amenities.*' => [
                    'exists:amenities,id',
                ],
           
        ];
    }
}