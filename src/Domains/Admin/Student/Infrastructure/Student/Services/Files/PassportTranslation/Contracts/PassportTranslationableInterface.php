<?php

declare(strict_types=1);

namespace Project\Domains\Admin\Student\Infrastructure\Student\Services\Files\PassportTranslation\Contracts;

use Project\Domains\Admin\Student\Domain\Student\ValueObjects\Files\PassportTranslation;

interface PassportTranslationableInterface
{
    public function getPassportTranslationClassName(): string;

    public function getPassportTranslation(): PassportTranslation;

    public function changePassportTranslation(PassportTranslationInterface $passportTranslation): void;

    public function deletePassportTranslation(): void;
}
