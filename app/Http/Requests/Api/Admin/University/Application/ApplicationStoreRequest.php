<?php

namespace App\Http\Requests\Api\Admin\University\Application;

use Illuminate\Foundation\Http\FormRequest;

class ApplicationStoreRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'email' => ['required', 'email', 'max:255'],
            'phone' => ['required', 'min:5', 'max:255'],
            'passport' => ['required', 'file', 'mimetypes:application/pdf'],
            'passport_translation' => ['required', 'file', 'mimetypes:application/pdf'],
            'school_attestat' => ['required', 'file', 'mimetypes:application/pdf'],
            'school_attestat_translation' => ['required', 'file', 'mimetypes:application/pdf'],
            'transcript' => ['required', 'file', 'mimetypes:application/pdf'],
            'transcript_translation' => ['required', 'file', 'mimetypes:application/pdf'],
            'equivalence_document' => ['required', 'file', 'mimetypes:application/pdf'],
            'biometric_photo' => ['required', 'file', 'mimetypes:application/pdf'],
        ];
    }
}
