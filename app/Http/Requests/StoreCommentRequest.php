<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreCommentRequest extends FormRequest
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

            // Reply text
            'body' => 'nullable|max:280',

            // Reply images
            'comment_images' => 'nullable|array',
            'comment_images.*' => 'image|max:2048',

            // Reply videos
            'comment_videos' => 'nullable|array',
            'comment_videos.*' => 'mimes:mp4|max:51200',

        ];
    }
}
