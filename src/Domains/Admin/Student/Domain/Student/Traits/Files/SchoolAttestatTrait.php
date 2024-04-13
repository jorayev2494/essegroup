<?php

declare(strict_types=1);

namespace Project\Domains\Admin\Student\Domain\Student\Traits\Files;

use Doctrine\ORM\Mapping as ORM;
use Project\Domains\Admin\Student\Domain\Student\ValueObjects\Files\SchoolAttestat;
use Project\Domains\Admin\Student\Infrastructure\Student\Services\Files\SchoolAttestat\Contracts\SchoolAttestatInterface;

trait SchoolAttestatTrait
{
    #[ORM\ManyToOne(targetEntity: SchoolAttestat::class, cascade: ['persist', 'remove'], inversedBy: 'application')]
    #[ORM\JoinColumn(name: 'school_attestat_uuid', referencedColumnName: 'uuid', nullable: false)]
    private SchoolAttestat $schoolAttestat;

    #[\Override]
    public function getSchoolAttestatClassName(): string
    {
        return SchoolAttestat::class;
    }

    #[\Override]
    public function getSchoolAttestat(): SchoolAttestat
    {
        return $this->schoolAttestat;
    }

    #[\Override]
    public function changeSchoolAttestat(SchoolAttestatInterface $schoolAttestat): void
    {
        $this->schoolAttestat = $schoolAttestat;
    }

    #[\Override]
    public function deleteSchoolAttestat(): void
    {
        // TODO: Implement deleteSchoolAttestat() method.
    }
}
