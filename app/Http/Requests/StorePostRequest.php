<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StorePostRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'title' => ['required', 'max:100'],
            'content' => ['required', 'max:10000'],
            'thumbnail_image_index' => ['nullable', 'max:2'],
            'images[]' => ['nullable', 'multiple_of:images', 'max:1024'],
            'tags' => ['nullable', 'array'],
        ];
    }
}
