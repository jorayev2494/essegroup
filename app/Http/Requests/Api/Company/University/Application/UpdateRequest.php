<?php

namespace App\Http\Requests\Api\Company\University\Application;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Project\Domains\Admin\University\Domain\Application\StatusValue;
use Project\Domains\Admin\University\Domain\Application\StatusValueRepositoryInterface;
use Project\Domains\Admin\University\Domain\Application\ValueObjects\StatusValueUuid;

class UpdateRequest extends FormRequest
{
    private StatusValueRepositoryInterface $statusValueRepository;

    protected function prepareForValidation(): void
    {
        $this->statusValueRepository = resolve(StatusValueRepositoryInterface::class);
    }

    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        /** @var StatusValue $statusValue */
        $statusValue = $this->statusValueRepository->findByUuid(StatusValueUuid::fromValue($this->get('status_value_uuid')));

        return [
            'student_uuid' => [
                'required',
                'uuid',
                Rule::exists('admin_db.student_students', 'uuid'),
            ],
            'alias_uuid' => [
                'required',
                'uuid',
                Rule::exists('admin_db.university_aliases', 'uuid'),
            ],
            'language_uuid' => [
                'required',
                'uuid',
                Rule::exists('admin_db.language_languages', 'uuid'),
            ],
            'degree_uuid' => [
                'required',
                'uuid',
                Rule::exists('admin_db.university_degrees', 'uuid'),
            ],
            'country_uuid' => [
                'required',
                'uuid',
                Rule::exists('admin_db.country_countries', 'uuid'),
            ],
            'university_uuid' => [
                'required',
                'uuid',
                Rule::exists('admin_db.university_universities', 'uuid'),
            ],
            'department_uuids' => [
                'required',
            ],
            'department_uuids.*' => [
                'uuid',
                Rule::exists('admin_db.university_departments', 'uuid'),
            ],

            'status_value_uuid' => [
                'required',
                'uuid',
                Rule::exists('admin_db.university_application_status_values', 'uuid')
                // ->where('is_first', false)
                ,
            ],

            'status.notes' => ['array'],
            'status.translations.*.note' => [
                Rule::requiredIf($statusValue->getIsRequiredNote()),
                'max:500',
            ],
        ];
    }
}
