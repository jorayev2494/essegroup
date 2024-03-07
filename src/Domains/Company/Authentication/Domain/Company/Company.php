<?php

declare(strict_types=1);

namespace Project\Domains\Company\Authentication\Domain\Company;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Project\Domains\Company\Authentication\Domain\Member\Member;
use Project\Shared\Contracts\ArrayableInterface;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity]
#[ORM\Table(name: 'auth_companies')]
class Company implements ArrayableInterface
{
    #[ORM\Id]
    #[ORM\Column]
    private string $uuid;

    #[ORM\OneToMany(targetEntity: Member::class, mappedBy: 'company')]
    private Collection $managers;

    private function __construct(string $uuid)
    {
        $this->uuid = $uuid;
        $this->managers = new ArrayCollection();
    }

    public static function fromPrimitives(string $uuid): self
    {
        return new self($uuid);
    }

    public function getUuid(): string
    {
        return $this->uuid;
    }

    #[\Override]
    public function toArray(): array
    {
        return [
            'uuid' => $this->uuid,
        ];
    }
}
