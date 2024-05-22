<?php

namespace App\Http\Requests\Api\Admin\Document;

use App\Rules\ValidateTranslationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Project\Domains\Admin\Document\Domain\Document\ValueObjects\TypeEnum;

class StoreRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'file' => [
                'required',
                'file',
                'mimetypes:application/pdf',
            ],
            'type' => [
                'required',
                'string',
                Rule::in(TypeEnum::cases()),
            ],
            'translations' => [
                'required',
                new ValidateTranslationRule([
                    'title',
                ]),
            ],
            'is_active' => [
                'required',
                'boolean',
            ],
        ];
    }
}
