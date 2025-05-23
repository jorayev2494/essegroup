<?php

namespace App\Http\Requests\Api\Admin\University\University;

use App\Rules\ValidateTranslationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Project\Domains\Admin\University\Domain\University\ValueObjects\Cover;
use Project\Domains\Admin\University\Domain\University\ValueObjects\Logo;

class UniversityUpdateRequest extends FormRequest
{
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
                'max:' . config('filesystems.file_max_size'),
                'mimetypes:image/*',
                 Rule::dimensions()->width(Logo::WIDTH)->height(Logo::HEIGHT),
            ],
            'cover' => [
                'nullable',
                'file',
                'max:' . config('filesystems.file_max_size'),
                'mimetypes:image/*',
                 Rule::dimensions()->width(Cover::WIDTH)->height(Cover::HEIGHT),
            ],
            'youtube_video_id' => ['required', 'string', 'max:15'],
            'translations' => [
                'required',
                new ValidateTranslationRule(['name', 'label', 'description']),
            ],
            'is_on_the_country_list' => ['required', 'boolean'],
            'top_position' => ['nullable', 'numeric', 'min:1'],
        ];
    }
}
