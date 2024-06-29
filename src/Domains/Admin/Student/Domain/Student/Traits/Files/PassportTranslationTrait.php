<?php

declare(strict_types=1);

namespace Project\Domains\Admin\Student\Domain\Student\Traits\Files;

use Doctrine\ORM\Mapping as ORM;
use Project\Domains\Admin\Student\Domain\Student\ValueObjects\Files\PassportTranslation;
use Project\Domains\Admin\Student\Infrastructure\Student\Services\Files\PassportTranslation\Contracts\PassportTranslationInterface;

trait PassportTranslationTrait
{
    #[ORM\OneToOne(targetEntity: PassportTranslation::class, inversedBy: 'student', cascade: ['persist', 'remove'], orphanRemoval: true)]
    #[ORM\JoinColumn(name: 'passport_translation_uuid', referencedColumnName: 'uuid', nullable: false)]
    private PassportTranslation $passportTranslation;

    #[\Override]
    public function getPassportTranslationClassName(): string
    {
        return PassportTranslation::class;
    }

    #[\Override]
    public function getPassportTranslation(): PassportTranslation
    {
        return $this->passportTranslation;
    }

    #[\Override]
    public function changePassportTranslation(PassportTranslationInterface $passportTranslation): void
    {
        $this->passportTranslation = $passportTranslation;
    }

    #[\Override]
    public function deletePassportTranslation(): void
    {
        // TODO: Implement deletePassportTranslation() method.
    }
}
