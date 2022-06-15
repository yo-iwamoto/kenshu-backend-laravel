<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdatePostRequest extends FormRequest
{
    /**
     * 未認証ユーザーを弾く
     *
     * @return bool
     */
    public function authorize()
    {
        return $this->user() !== null;
    }

    /**
     * @return array<string, string[]>
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
