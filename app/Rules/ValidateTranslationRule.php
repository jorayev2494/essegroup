<?php

declare(strict_types=1);

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;
class ValidateTranslationRule implements ValidationRule
{
    private readonly array $locales;

    function __construct(
        private readonly array $params,
        private readonly array $rules = [],
    ) {
        $this->locales = config('app.available_client_translation_locales');
    }

    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        if (empty($value)) {
            $fail($attribute, "The $attribute field is required.");
        }

        foreach ($this->locales as $locale) {
            if (! array_key_exists($locale, $value)) {
                $fail("$attribute.$locale", "The $locale field is required.");
            } else {
                foreach ($this->params as $prop) {
                    if (! array_key_exists($prop, $value[$locale])) {
                        $fail("$attribute.$locale.$prop", "The $locale $prop field is required.");
                    } else {
                        // nullable
                        if (array_key_exists($prop, $this->rules) && in_array('nullable', $this->rules[$prop])) {
                            continue;
                        }

                        if (is_null($value[$locale][$prop])) {
                            $fail("$attribute.$locale.$prop", "The $locale $prop field is not be null");
                        }
                    }
                }
            }
        }
    }
}
