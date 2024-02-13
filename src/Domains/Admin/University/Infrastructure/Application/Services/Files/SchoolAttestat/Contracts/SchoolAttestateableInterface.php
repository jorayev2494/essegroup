<?php

declare(strict_types=1);

namespace Project\Domains\Admin\University\Infrastructure\Application\Services\Files\SchoolAttestat\Contracts;

use Project\Domains\Admin\University\Domain\Application\ValueObjects\SchoolAttestat;

interface SchoolAttestateableInterface
{
    public function getSchoolAttestatClassName(): string;

    public function getSchoolAttestat(): SchoolAttestat;

    public function changeSchoolAttestat(SchoolAttestatInterface $schoolAttestat): void;

    public function deleteSchoolAttestat(): void;
}
