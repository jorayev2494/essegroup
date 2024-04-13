<?php

namespace App\Http\Requests\Api\Admin\University\Faculty;

use App\Rules\ValidateTranslationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class FacultyCreateRequest extends FormRequest
{
    private const int LOGO_WIDTH = 400;

    private const int LOGO_HEIGHT = 400;

    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name_uuid' => [
                'required',
                'string',
                Rule::exists('admin_db.faculty_faculty_names', 'uuid'),
            ],
            'university_uuid' => [
                'required',
                'string',
                Rule::exists('admin_db.university_universities', 'uuid'),
            ],
            'logo' => [
                'required',
                'file',
                'mimetypes:image/*',
                // Rule::dimensions()->width(self::LOGO_WIDTH)->height(self::LOGO_HEIGHT),
            ],
            'translations' => [
                'array',
                new ValidateTranslationRule(['description']),
            ],
            // 'is_active' => [
            //     'required',
            // ],
        ];
    }
}
