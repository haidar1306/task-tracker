<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateBedTypeRequest extends FormRequest
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
                Rule::unique('bed_types')->ignore($this->bedType),
            ],
            'description' => ['nullable','max:1000'],
            'status' => ['required','boolean'],
        ];
    }
}