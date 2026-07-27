<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreTweetRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return auth()->check();
    }

    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {
        return [
            // Tweet text
            'body' => 'required|max:280',

            // Images
            'images' => 'nullable|array',
            'images.*' => 'image|max:2048',

            // Videos
            'videos' => 'nullable|array',
            'videos.*' => 'mimes:mp4|max:51200',
        ];
    }
}
