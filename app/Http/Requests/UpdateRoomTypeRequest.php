<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateRoomTypeRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }                                 

    public function rules()
    {
        return [
            'name' => [
                'required',
                'max:100',
                Rule::unique('room_types')->ignore($this->roomType),
            ],

            'capacity' => 'required|integer|min:1',

            'price' => 'required|numeric|min:0',

            'description' => 'nullable|max:1000',

            'image' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',

            'status' => 'required|boolean',
        ];
    }
}
