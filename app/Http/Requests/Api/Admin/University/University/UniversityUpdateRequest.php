<?php

namespace App\Http\Requests\Api\Admin\University\University;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UniversityUpdateRequest extends FormRequest
{
    private const int LOGO_WIDTH = 400;

    private const int LOGO_HEIGHT = 400;

    private const int COVER_WIDTH = 1280;

    private const int COVER_HEIGHT = 568;

    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'logo' => [
                'nullable',
                'file',
                'mimetypes:image/*',
                // Rule::dimensions()->width(self::LOGO_WIDTH)->height(self::LOGO_HEIGHT),
            ],
            'cover' => [
                'nullable',
                'file',
                'mimetypes:image/*',
                // Rule::dimensions()->width(self::COVER_WIDTH)->height(self::COVER_HEIGHT),
            ],
            'youtube_video_id' => ['required', 'string', 'max:15'],
            'translations' => ['required', 'array'],
            'translations.*.name' => 'required',
            'translations.*.label' => 'required',
            'translations.*.description' => 'required',
        ];
    }
}
