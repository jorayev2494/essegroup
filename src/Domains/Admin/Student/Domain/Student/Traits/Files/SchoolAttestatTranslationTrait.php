<?php

declare(strict_types=1);

namespace Project\Domains\Admin\Student\Domain\Student\Traits\Files;

use Doctrine\ORM\Mapping as ORM;
use Project\Domains\Admin\Student\Domain\Student\ValueObjects\Files\SchoolAttestatTranslation;
use Project\Domains\Admin\Student\Infrastructure\Student\Services\Files\SchoolAttestatTranslation\Contracts\SchoolAttestatTranslationInterface;

trait SchoolAttestatTranslationTrait
{
    #[ORM\OneToOne(targetEntity: SchoolAttestatTranslation::class, inversedBy: 'student', cascade: ['persist', 'remove'], orphanRemoval: true)]
    #[ORM\JoinColumn(name: 'school_attestat_translation_uuid', referencedColumnName: 'uuid', nullable: false)]
    private SchoolAttestatTranslation $schoolAttestatTranslation;

    #[\Override]
    public function getSchoolAttestatTranslationClassName(): string
    {
        return SchoolAttestatTranslation::class;
    }

    #[\Override]
    public function getSchoolAttestatTranslation(): SchoolAttestatTranslation
    {
        return $this->schoolAttestatTranslation;
    }

    #[\Override]
    public function changeSchoolAttestatTranslation(SchoolAttestatTranslationInterface $schoolAttestatTranslation): void
    {
        $this->schoolAttestatTranslation = $schoolAttestatTranslation;
    }

    #[\Override]
    public function deleteSchoolAttestatTranslation(): void
    {
        // TODO: Implement deleteSchoolAttestatTranslation() method.
    }
}
