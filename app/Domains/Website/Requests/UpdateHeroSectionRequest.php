<?php

namespace App\Domains\Website\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateHeroSectionRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
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
            'badge' => ['nullable', 'string', 'max:100'],
            'heading' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],

            'primary_button_text' => ['nullable', 'string', 'max:50'],
            'primary_button_link' => ['nullable', 'string', 'max:255'],

            'secondary_button_text' => ['nullable', 'string', 'max:50'],
            'secondary_button_link' => ['nullable', 'string', 'max:255'],

            'hero_image' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:2048'],
            'background_image' => [
                'nullable',
                'image',
                'mimes:jpg,jpeg,png,webp',
                'max:2048',
            ],
            'background_color' => ['nullable','string','max:20'],
            'overlay_opacity' => ['required','integer','min:0','max:100'],
            'text_color' => ['nullable', 'string'],

            'status' => ['required', 'boolean'],
        ];
    }

    /**
     * Custom Validation Messages
     */
    public function messages()
    {
        return [
            'heading.required' => 'Hero heading is required.',
            'hero_image.image' => 'Please upload a valid image.',
            'hero_image.mimes' => 'Only JPG, JPEG, PNG and WEBP images are allowed.',
            'hero_image.max' => 'Image size must not exceed 2 MB.',
            'background_image.image' => 'Please upload a valid background image.',
            'background_image.mimes' => 'Only JPG, JPEG, PNG and WEBP images are allowed.',
            'background_image.max' => 'Background image size must not exceed 2 MB.',    
        ];
    }
}