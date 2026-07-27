<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreMessageRequest extends FormRequest
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

            'body' => 'nullable|string|max:5000',

            'message_images' => 'nullable|array',
            'message_images.*' => 'image|max:2048',

            'message_videos' => 'nullable|array',
            'message_videos.*' => 'mimes:mp4|max:51200',

        ];
    }
}
