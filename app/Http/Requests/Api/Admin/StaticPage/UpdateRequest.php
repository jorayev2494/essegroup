<?php

namespace App\Http\Requests\Api\Admin\StaticPage;

use App\Rules\ValidateTranslationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Project\Domains\Admin\StaticPage\Domain\StaticPage\ValueObjects\Cover;

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
                'max:' . config('filesystems.file_max_size'),
                'mimetypes:image/*',
                // Rule::dimensions()->width(Cover::WIDTH)->height(Cover::HEIGHT),
            ],
        ];
    }
}
