<?php

declare(strict_types=1);

namespace Project\Domains\Admin\Student\Infrastructure\Student\Services\Files\SchoolAttestatTranslation\Contracts;

use Project\Domains\Admin\Student\Domain\Student\ValueObjects\Files\SchoolAttestatTranslation;

interface SchoolAttestatTranslationableInterface
{
    public function getSchoolAttestatTranslationClassName(): string;

    public function getSchoolAttestatTranslation(): SchoolAttestatTranslation;

    public function changeSchoolAttestatTranslation(SchoolAttestatTranslationInterface $schoolAttestatTranslation): void;

    public function deleteSchoolAttestatTranslation(): void;
}
