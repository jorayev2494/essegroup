<?php

declare(strict_types=1);

namespace Project\Domains\Admin\University\Domain\Country;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Event\PrePersistEventArgs;
use Doctrine\ORM\Event\PreUpdateEventArgs;
use Doctrine\ORM\Mapping as ORM;
use DateTimeImmutable;
use Project\Domains\Admin\University\Domain\Application\Application;
use Project\Domains\Admin\University\Domain\Company\Company;
use Project\Shared\Contracts\ArrayableInterface;

#[ORM\Entity]
#[ORM\Table(name: 'university_countries')]
#[ORM\HasLifecycleCallbacks]
class Country implements ArrayableInterface
{
    #[ORM\Id]
    #[ORM\Column]
    private string $uuid;

    #[ORM\Column(name: 'value', type: Types::STRING)]
    private string $value;

    #[ORM\Column(name: 'iso', type: Types::STRING, length: 3)]
    private string $iso;

    #[ORM\Column(name: 'company_uuid', type: Types::STRING, nullable: false)]
    private string $companyUuid;

    #[ORM\ManyToOne(targetEntity: Company::class, inversedBy: 'countries', cascade: ['persist'])]
    #[ORM\JoinColumn(name: 'company_uuid', referencedColumnName: 'uuid')]
    private ?Company $company;

    #[ORM\OneToMany(targetEntity: Application::class, mappedBy: 'country', cascade: ['persist', 'remove'])]
    private Collection $applications;

    #[ORM\Column(name: 'is_active', type: Types::BOOLEAN)]
    private bool $isActive;

    #[ORM\Column(name: 'created_at', type: Types::DATETIME_IMMUTABLE)]
    private DateTimeImmutable $createdAt;

    #[ORM\Column(name: 'updated_at', type: Types::DATETIME_IMMUTABLE)]
    private DateTimeImmutable $updatedAt;

    private function __construct(string $uuid, string $value, string $iso, bool $isActive)
    {
        $this->uuid = $uuid;
        $this->value = $value;
        $this->iso = $iso;
        // $this->companyUuid = $companyUuid;
        $this->applications = new ArrayCollection();
        $this->isActive = $isActive;
    }

    public static function fromPrimitives(string $uuid, string $value, string $iso, bool $isActive): self
    {
        return new self($uuid, $value, $iso, $isActive);
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

    public function setCompany(?Company $company): void
    {
        $this->company = $company;
    }

    public function isEquals(self $other): bool
    {
        return $this->uuid === $other->uuid;
    }

    public function isNotEquals(self $other): bool
    {
        return $this->uuid !== $other->uuid;
    }

    #[ORM\PrePersist]
    public function prePersisting(PrePersistEventArgs $event): void
    {
        $this->createdAt = new DateTimeImmutable();
        $this->updatedAt = new DateTimeImmutable();
    }

    #[ORM\PreUpdate]
    public function preUpdating(PreUpdateEventArgs $event): void
    {
        $this->updatedAt = new DateTimeImmutable();
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
