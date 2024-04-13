<?php

declare(strict_types=1);

namespace Project\Domains\Admin\Student\Domain\Student\Traits\Files;

use Doctrine\ORM\Mapping as ORM;
use Project\Domains\Admin\Student\Domain\Student\ValueObjects\Files\Passport;
use Project\Domains\Admin\Student\Infrastructure\Student\Services\Files\Passport\Contracts\PassportInterface;

trait PassportTrait
{
    #[ORM\ManyToOne(targetEntity: Passport::class, cascade: ['persist', 'remove'], inversedBy: 'application')]
    #[ORM\JoinColumn(name: 'passport_uuid', referencedColumnName: 'uuid', nullable: false)]
    private Passport $passport;

    #[\Override]
    public function getPassport(): Passport
    {
        return $this->passport;
    }

    #[\Override]
    public function changePassport(PassportInterface $passport): void
    {
        $this->passport = $passport;
    }

    #[\Override]
    public function getPassportClassName(): string
    {
        return Passport::class;
    }

    #[\Override]
    public function deletePassport(): void
    {
        // TODO: Implement deletePassport() method.
    }
}
