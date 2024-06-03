<?php

declare(strict_types=1);

namespace Project\Domains\Admin\Student\Domain\Student\ValueObjects\Embeddables;

use Doctrine\DBAL\Types\DateImmutableType;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Project\Domains\Admin\Student\Domain\Student\ValueObjects\PassportNumber;
use Project\Domains\Admin\Student\Infrastructure\Student\Repositories\Doctrine\Types\PassportNumberType;
use Project\Shared\Contracts\ArrayableInterface;
use DateTimeImmutable;

#[ORM\Embeddable]
class PassportInfo implements ArrayableInterface
{
    #[ORM\Column(type: PassportNumberType::NAME, length: 50, unique: true)]
    private PassportNumber $number;

    #[ORM\Column(name: 'date_of_issue', type: Types::DATE_IMMUTABLE, nullable: true)]
    private ?DateTimeImmutable $dateOfIssue;

    #[ORM\Column(name: 'date_of_expiry', type: Types::DATE_IMMUTABLE, nullable: true)]
    private ?DateTimeImmutable $dateOfExpiry;

    private function __construct(PassportNumber $number)
    {
        $this->number = $number;
        $this->dateOfIssue = null;
        $this->dateOfExpiry = null;
    }

    public static function make(PassportNumber $number): self
    {
        return new self($number);
    }

    public function getNumber(): PassportNumber
    {
        return $this->number;
    }

    public function changeNumber(PassportNumber $number): self
    {
        if ($this->number->isNotEquals($number)) {
            $this->number = $number;
        }

        return $this;
    }

    public function getDateOfIssue(): ?DateTimeImmutable
    {
        return $this->dateOfIssue;
    }

    public function changeDateOfIssue(DateTimeImmutable $dateOfIssue): self
    {
        if ($this->dateOfIssue?->getTimestamp() !== $dateOfIssue->getTimestamp()) {
            $this->dateOfIssue = $dateOfIssue;
        }

        return $this;
    }

    public function getDateOfExpiry(): ?DateTimeImmutable
    {
        return $this->dateOfExpiry;
    }

    public function changeDateOfExpiry(DateTimeImmutable $dateOfExpiry): self
    {
        if ($this->dateOfExpiry?->getTimestamp() !== $dateOfExpiry->getTimestamp()) {
            $this->dateOfExpiry = $dateOfExpiry;
        }

        return $this;
    }

    public function isEquals(self $other): bool
    {
        return $this->number->isEquals($other->getNumber())
            || $this->dateOfIssue->getTimestamp() === $other->getDateOfIssue()->getTimestamp()
            || $this->dateOfExpiry->getTimestamp() === $other->getDateOfExpiry()->getTimestamp();
    }

    public function isNotEquals(self $other): bool
    {
        return $this->number->isNotEquals($other->getNumber())
            || $this->dateOfIssue->getTimestamp() !== $other->getDateOfIssue()->getTimestamp()
            || $this->dateOfExpiry->getTimestamp() !== $other->getDateOfExpiry()->getTimestamp();
    }

    public function toArray(): array
    {
        return [
            'passport_number' => $this->number->value,
            'passport_date_of_issue' => $this->dateOfIssue?->getTimestamp(),
            'passport_date_of_expiry' => $this->dateOfExpiry?->getTimestamp(),
        ];
    }
}
