<?php

declare(strict_types=1);

namespace Project\Domains\Admin\Student\Infrastructure\Student\Services\Files\SchoolAttestat\Contracts;

use Project\Domains\Admin\Student\Domain\Student\ValueObjects\Files\SchoolAttestat;

interface SchoolAttestateableInterface
{
    public function getSchoolAttestatClassName(): string;

    public function getSchoolAttestat(): SchoolAttestat;

    public function changeSchoolAttestat(SchoolAttestatInterface $schoolAttestat): void;

    public function deleteSchoolAttestat(): void;
}
