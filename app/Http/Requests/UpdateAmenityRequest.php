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
        $amenity = $this->route('amenity');

        $amenityId = is_object($amenity)
            ? $amenity->id
            : $amenity;

        return [
            'name' => [
                'required',
                'string',
                'max:100',
                Rule::unique('amenities', 'name')->ignore($amenityId),
            ],

            'description' => [
                'nullable',
                'string',
                'max:1000',
            ],

            'image' => [
                'nullable',
                'url',
                'max:500',
            ],

            'icon' => [
                'nullable',
                'string',
                'max:100',
            ],

            'tag' => [
                'nullable',
                'string',
                'max:100',
            ],

            'status' => [
                'required',
                'boolean',
            ],
        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'Please enter the amenity name.',
            'name.unique' => 'This amenity name already exists.',
            'name.max' => 'Amenity name cannot exceed 100 characters.',

            'description.max' => 'Description cannot exceed 1000 characters.',

            'image.url' => 'Please enter a valid image URL.',
            'image.max' => 'Image URL cannot exceed 500 characters.',

            'icon.max' => 'Icon name cannot exceed 100 characters.',
            'tag.max' => 'Tag cannot exceed 100 characters.',

            'status.required' => 'Please select an amenity status.',
            'status.boolean' => 'Please select a valid status.',
        ];
    }
}