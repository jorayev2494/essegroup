<?php

namespace App\Http\Requests\Api\Admin\StaticPage;

use App\Rules\ValidateTranslationRule;
use Illuminate\Foundation\Http\FormRequest;

class UpdateRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'translations' => [
                'required',
                new ValidateTranslationRule(['title', 'content']),
            ],
            'cover' => [
                'nullable',
                'file',
                'mimetypes:image/*',
                'dimensions:width=466,height=456',
            ],
        ];
    }
}
