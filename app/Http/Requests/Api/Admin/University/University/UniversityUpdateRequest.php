<?php

namespace App\Http\Requests\Api\Admin\University\University;

use App\Rules\ValidateTranslationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UniversityUpdateRequest extends FormRequest
{
    private const int LOGO_WIDTH = 200;

    private const int LOGO_HEIGHT = 200;

    private const int COVER_WIDTH = 1280;

    private const int COVER_HEIGHT = 568;

    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'country_uuid' => [
                'required',
                'string',
                Rule::exists('admin_db.country_countries', 'uuid'),
            ],
            'city_uuid' => [
                'required',
                'string',
                Rule::exists('admin_db.country_cities', 'uuid'),
            ],
            'logo' => [
                'nullable',
                'file',
                'mimetypes:image/*',
                Rule::dimensions()->width(self::LOGO_WIDTH)->height(self::LOGO_HEIGHT),
            ],
            'cover' => [
                'nullable',
                'file',
                'mimetypes:image/*',
                Rule::dimensions()->width(self::COVER_WIDTH)->height(self::COVER_HEIGHT),
            ],
            'youtube_video_id' => ['required', 'string', 'max:15'],
            'translations' => [
                'required',
                new ValidateTranslationRule(['name', 'label', 'description']),
            ],
            'is_on_the_country_list' => ['required', 'boolean'],
        ];
    }
}
