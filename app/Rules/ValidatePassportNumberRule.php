<?php

declare(strict_types=1);

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;
use Project\Domains\Admin\Student\Domain\Student\ValueObjects\PassportNumber;

class ValidatePassportNumberRule implements ValidationRule
{
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        if (! preg_match(PassportNumber::REGEX_PATTERN, $value)) {
           $fail('passport_number', 'The passport number is invalid');
        }
    }
}
