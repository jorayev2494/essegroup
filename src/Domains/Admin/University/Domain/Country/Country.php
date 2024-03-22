<?php

declare(strict_types=1);

namespace Project\Domains\Admin\University\Domain\Country;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Project\Domains\Admin\University\Domain\Application\Application;
use Project\Shared\Contracts\ArrayableInterface;
use Project\Shared\Domain\Traits\ActivableTrait;
use Project\Shared\Domain\Traits\CreatedAtAndUpdatedAtTrait;

#[ORM\Entity]
#[ORM\Table(name: 'university_countries')]
#[ORM\HasLifecycleCallbacks]
class Country implements ArrayableInterface
{
    use ActivableTrait,
        CreatedAtAndUpdatedAtTrait;

    #[ORM\Id]
    #[ORM\Column]
    private string $uuid;

    #[ORM\Column(name: 'value', type: Types::STRING)]
    private string $value;

    #[ORM\Column(name: 'iso', type: Types::STRING, length: 3)]
    private string $iso;

    #[ORM\Column(name: 'company_uuid', type: Types::STRING, nullable: false)]
    private string $companyUuid;

    #[ORM\OneToMany(targetEntity: Application::class, mappedBy: 'country', cascade: ['persist'])]
    private Collection $applications;

    private function __construct(string $uuid, string $value, string $companyUuid, string $iso, bool $isActive)
    {
        $this->uuid = $uuid;
        $this->value = $value;
        $this->companyUuid = $companyUuid;
        $this->iso = $iso;
        $this->applications = new ArrayCollection();
        $this->isActive = $isActive;
    }

    public static function fromPrimitives(string $uuid, string $value, string $companyUuid, string $iso, bool $isActive): self
    {
        return new self($uuid, $value, $companyUuid, $iso, $isActive);
    }

    public function getUuid(): string
    {
        return $this->uuid;
    }

    public function setValue(string $value): void
    {
        $this->value = $value;
    }

    public function setISO(string $iso): void
    {
        $this->iso = $iso;
    }

    public function setIsActive(bool $isActive): void
    {
        $this->isActive = $isActive;
    }

    public function setCompanyUuid(string $companyUuid): void
    {
        $this->companyUuid = $companyUuid;
    }

    public function isEquals(self $other): bool
    {
        return $this->uuid === $other->uuid;
    }

    public function isNotEquals(self $other): bool
    {
        return $this->uuid !== $other->uuid;
    }

    #[\Override]
    public function toArray(): array
    {
        return [
            'uuid' => $this->uuid,
            'value' => $this->value,
            'iso' => $this->iso,
            'company_uuid' => $this->companyUuid,
            // 'company' => $this->company->toArray(),
            'is_active' => $this->isActive,
            'created_at' => $this->createdAt->getTimestamp(),
            'updated_at' => $this->updatedAt->getTimestamp(),
        ];
    }
}
