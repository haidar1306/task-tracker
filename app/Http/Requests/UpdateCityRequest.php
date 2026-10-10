<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateCityRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'country_id' => 'required|exists:countries,id',

            'state_id' => [
                'required',
                'exists:states,id',
            ],

            'name' => [
                'required',
                'string',
                'max:255',
                Rule::unique('cities', 'name')
                    ->where(fn ($query) => $query->where('state_id', $this->state_id))
                    ->ignore($this->city->id),
            ],
        ];
    }
}