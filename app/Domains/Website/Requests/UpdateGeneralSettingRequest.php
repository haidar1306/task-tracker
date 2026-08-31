<?php

namespace App\Domains\Website\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateGeneralSettingRequest extends FormRequest
{
    /**
     * Determine if the user is authorized.
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Validation Rules
     */
    public function rules()
    {
        return [
            'website_name' => ['required', 'string', 'max:255'],

            'website_logo' => ['nullable', 'image', 'mimes:jpg,jpeg,png,svg,webp', 'max:2048'],

            'favicon' => ['nullable', 'image', 'mimes:png,ico,jpg,jpeg', 'max:1024'],

            'email' => ['nullable', 'email', 'max:255'],

            'phone' => ['nullable', 'string', 'max:30'],

            'address' => ['nullable', 'string'],

            'copyright' => ['nullable', 'string', 'max:255'],

            'status' => ['required', 'boolean'],
        ];
    }

    /**
     * Custom Messages
     */
    public function messages()
    {
        return [
            'website_name.required' => 'Website name is required.',
            'website_logo.image' => 'Please upload a valid logo.',
            'favicon.image' => 'Please upload a valid favicon.',
            'email.email' => 'Please enter a valid email address.',
        ];
    }
}