<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateAmenityRequest extends FormRequest
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
                Rule::unique('amenities')->ignore($this->amenity),
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