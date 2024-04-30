<?php

namespace App\Http\Requests\Api\Admin\Announcement\Announcement;

use App\Rules\ValidateTranslationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Project\Domains\Admin\Announcement\Domain\Announcement\ValueObjects\ForItemEnum;

class StoreRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'start_time' => [
                'required',
                'date',
            ],
            'for' => [
                'required',
                Rule::in(ForItemEnum::cases()),
            ],
            'end_time' => [
                'nullable',
                'date',
            ],
            'translations' => [
                'required',
                'array',
                new ValidateTranslationRule(['title', 'content']),
            ],
            'is_active' => [
                'required',
                'boolean',
            ],
        ];
    }
}
