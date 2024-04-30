<?php

declare(strict_types=1);

namespace Project\Domains\Admin\Manager\Domain\Manager\ValueObjects;

use Doctrine\ORM\Mapping as ORM;
use Project\Domains\Admin\Manager\Infrastructure\Manager\Repositories\Doctrine\Types\FirstNameType;
use Project\Domains\Admin\Manager\Infrastructure\Manager\Repositories\Doctrine\Types\LastNameType;
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

    public function changeFirstName(FirstName $firstName): self
    {
        if ($this->firstName->isNotEquals($firstName)) {
            $this->firstName = $firstName;
        }

        return $this;
    }

    public function getLastName(): LastName
    {
        return $this->lastName;
    }

    public function changeLastName(LastName $lastName): self
    {
        if ($this->lastName->isNotEquals($lastName)) {
            $this->lastName = $lastName;
        }

        return $this;
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
