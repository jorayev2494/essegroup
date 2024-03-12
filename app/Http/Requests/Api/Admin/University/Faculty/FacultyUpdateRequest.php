<?php

namespace App\Http\Requests\Api\Admin\University\Faculty;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class FacultyUpdateRequest extends FormRequest
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
            'company_uuid' => [
                'required',
                'string',
                Rule::exists('admin_db.company_companies', 'uuid'),
            ],
            'university_uuid' => [
                'required',
                'string',
                Rule::exists('admin_db.university_universities', 'uuid'),
            ],
            'logo' => [
                'nullable',
                'file',
                'mimetypes:image/*',
                // Rule::dimensions()->width(self::LOGO_WIDTH)->height(self::LOGO_HEIGHT),
            ],
            'translations' => ['required', 'array'],
            'translations.*.name' => ['required'],
            // 'translations.*.label' => ['required'],
            'translations.*.description' => ['required'],
            // 'is_active' => [
            //     'required',
            // ],
        ];
    }
}
