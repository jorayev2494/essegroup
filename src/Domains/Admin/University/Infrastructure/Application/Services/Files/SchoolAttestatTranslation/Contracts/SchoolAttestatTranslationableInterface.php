<?php

declare(strict_types=1);

namespace Project\Domains\Admin\University\Infrastructure\Application\Services\Files\SchoolAttestatTranslation\Contracts;

use Project\Domains\Admin\University\Domain\Application\ValueObjects\SchoolAttestatTranslation;

interface SchoolAttestatTranslationableInterface
{
    public function getSchoolAttestatTranslationClassName(): string;

    public function getSchoolAttestatTranslation(): SchoolAttestatTranslation;

    public function changeSchoolAttestatTranslation(SchoolAttestatTranslationInterface $schoolAttestatTranslation): void;

    public function deleteSchoolAttestatTranslation(): void;
}
