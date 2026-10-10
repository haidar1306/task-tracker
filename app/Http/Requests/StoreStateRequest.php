<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreStateRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }
  

public function rules(): array
{
    return [
        'country_id' => ['required', 'exists:countries,id'],

        'name' => [
            'required',
            'string',
            'min:2',
            'max:100',
            'regex:/^[A-Za-z\s]+$/',
            Rule::unique('states', 'name')
                ->where(fn ($query) => $query->where('country_id', $this->country_id)),
        ],
    ];
}
}