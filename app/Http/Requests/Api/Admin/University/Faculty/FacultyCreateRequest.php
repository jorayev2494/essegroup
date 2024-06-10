<?php

namespace App\Http\Requests\Api\Admin\University\Faculty;

use App\Rules\ValidateTranslationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Project\Domains\Admin\University\Domain\Faculty\ValueObjects\Logo;

class FacultyCreateRequest extends FormRequest
{
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
                 Rule::dimensions()->width(Logo::WIDTH)->height(Logo::HEIGHT),
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
