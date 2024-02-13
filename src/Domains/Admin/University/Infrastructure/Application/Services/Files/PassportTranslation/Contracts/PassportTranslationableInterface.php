<?php

declare(strict_types=1);

namespace Project\Domains\Admin\University\Infrastructure\Application\Services\Files\PassportTranslation\Contracts;

use Project\Domains\Admin\University\Domain\Application\ValueObjects\PassportTranslation;

interface PassportTranslationableInterface
{
    public function getPassportTranslationClassName(): string;

    public function getPassportTranslation(): PassportTranslation;

    public function changePassportTranslation(PassportTranslationInterface $passportTranslation): void;

    public function deletePassportTranslation(): void;
}
