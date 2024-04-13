<?php

declare(strict_types=1);

namespace Project\Domains\Admin\Student\Domain\Student\ValueObjects\Embeddables;

use Doctrine\ORM\Mapping as ORM;
use Project\Domains\Admin\Student\Domain\Student\ValueObjects\FirstName;
use Project\Domains\Admin\Student\Domain\Student\ValueObjects\LastName;
use Project\Domains\Admin\Student\Infrastructure\Student\Repositories\Doctrine\Types\FirstNameType;
use Project\Domains\Admin\Student\Infrastructure\Student\Repositories\Doctrine\Types\LastNameType;
use Project\Shared\Contracts\ArrayableInterface;

#[ORM\Embeddable]
class FullName implements ArrayableInterface
{
    #[ORM\Column(name: 'first_name', type: FirstNameType::NAME)]
    private FirstName $firstName;

    #[ORM\Column(name: 'last_name', type: LastNameType::NAME)]
    private LastName $lastName;

    private function __construct(FirstName $firstName, LastName $lastName)
    {
        $this->firstName = $firstName;
        $this->lastName = $lastName;
    }

    public static function make(FirstName $firstName, LastName $lastName): self
    {
        return new self($firstName, $lastName);
    }

    public function getFirstName(): FirstName
    {
        return $this->firstName;
    }

    public function getLastName(): LastName
    {
        return $this->lastName;
    }

    public function changeFirstName(FirstName $firstName): self
    {
        if ($this->firstName->isNotEquals($firstName)) {
            $this->firstName = $firstName;
        }

        return $this;
    }

    public function changeLastName(LastName $lastName): self
    {
        if ($this->lastName->isNotEquals($lastName)) {
            $this->lastName = $lastName;
        }

        return $this;
    }

    public function isEquals(self $other): bool
    {
        return $this->firstName->isEquals($other->getFirstName()) || $this->lastName->isEquals($other->getLastName());
    }

    public function isNotEquals(self $other): bool
    {
        return $this->firstName->isNotEquals($other->getFirstName()) || $this->lastName->isNotEquals($other->getLastName());
    }

    public function toArray(): array
    {
        return [
            'full_name' => $this->firstName->value . ' ' . $this->lastName->value,
            'first_name' => $this->firstName->value,
            'last_name' => $this->lastName->value,
        ];
    }
}
