<?php

declare(strict_types=1);

namespace Project\Domains\Admin\Country\Domain\Country;

use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Event\PrePersistEventArgs;
use Doctrine\ORM\Event\PreUpdateEventArgs;
use Doctrine\ORM\Mapping as ORM;
use DateTimeImmutable;
use Project\Domains\Admin\Country\Domain\Country\Events\CountryWasChangedCompanyDomainEvent;
use Project\Domains\Admin\Country\Domain\Country\Events\CountryWasChangedIsActiveDomainEvent;
use Project\Domains\Admin\Country\Domain\Country\Events\CountryWasChangedISODomainEvent;
use Project\Domains\Admin\Country\Domain\Country\Events\CountryWasChangedValueDomainEvent;
use Project\Domains\Admin\Country\Domain\Country\Events\CountryWasCreatedDomainEvent;
use Project\Domains\Admin\Country\Domain\Country\Events\CountryWasDeleteDomainEvent;
use Project\Domains\Admin\Country\Domain\Country\ValueObjects\CompanyUuid;
use Project\Domains\Admin\Country\Domain\Country\ValueObjects\ISO;
use Project\Domains\Admin\Country\Domain\Country\ValueObjects\Value;
use Project\Domains\Admin\Country\Infrastructure\Country\Repositories\Doctrine\Types\CompanyUuidType;
use Project\Domains\Admin\Country\Infrastructure\Country\Repositories\Doctrine\Types\ISOType;
use Project\Domains\Admin\Country\Infrastructure\Country\Repositories\Doctrine\Types\ValueType;
use Project\Shared\Domain\Aggregate\AggregateRoot;

#[ORM\Entity]
#[ORM\Table(name: 'country_countries')]
#[ORM\HasLifecycleCallbacks]
class Country extends AggregateRoot
{
    #[ORM\Id]
    #[ORM\Column]
    private string $uuid;

    #[ORM\Column(name: 'value', type: ValueType::NAME)]
    private Value $value;

    #[ORM\Column(name: 'iso', type: ISOType::NAME, length: 3)]
    private ISO $iso;

    #[ORM\Column(name: 'company_uuid', type: CompanyUuidType::NAME, nullable: false)]
    private CompanyUuid $companyUuid;

    #[ORM\Column(name: 'is_active', type: Types::BOOLEAN)]
    private bool $isActive;

    #[ORM\Column(name: 'created_at', type: Types::DATETIME_IMMUTABLE)]
    private DateTimeImmutable $createdAt;

    #[ORM\Column(name: 'updated_at', type: Types::DATETIME_IMMUTABLE)]
    private DateTimeImmutable $updatedAt;

    private function __construct(string $uuid, Value $value, ISO $iso, CompanyUuid $companyUuid, bool $isActive)
    {
        $this->uuid = $uuid;
        $this->value = $value;
        $this->iso = $iso;
        $this->companyUuid = $companyUuid;
        $this->isActive = $isActive;
    }

    public static function create(string $uuid, Value $value, ISO $iso, CompanyUuid $companyUuid, bool $isActive): self
    {
        $country = new self($uuid, $value, $iso, $companyUuid, $isActive);
        $country->record(
            new CountryWasCreatedDomainEvent(
                $country->uuid,
                $country->value->value,
                $country->iso->value,
                $country->companyUuid->value,
                $country->isActive
            )
        );

        return $country;
    }

    public function getUuid(): string
    {
        return $this->uuid;
    }

    public function changeValue(Value $value): void
    {
        if ($this->value->isNotEquals($value)) {
            $this->value = $value;
            $this->record(
                new CountryWasChangedValueDomainEvent(
                    $this->uuid,
                    $this->value->value
                )
            );
        }
    }

    public function changeISO(ISO $iso): void
    {
        if ($this->iso->isNotEquals($iso)) {
            $this->iso = $iso;
            $this->record(
                new CountryWasChangedISODomainEvent(
                    $this->uuid,
                    $this->iso->value
                )
            );
        }
    }

    public function changeCompanyUuid(CompanyUuid $companyUuid): void
    {
        if ($this->companyUuid !== $companyUuid) {
            $this->companyUuid = $companyUuid;
            $this->record(new CountryWasChangedCompanyDomainEvent($this->uuid, $this->companyUuid->value));
        }
    }

    public function changeIsActive(bool $isActive): void
    {
        if ($this->isActive !== $isActive) {
            $this->isActive = $isActive;
            $this->record(
                new CountryWasChangedIsActiveDomainEvent(
                    $this->uuid,
                    $this->isActive,
                )
            );
        }
    }

    public function delete(): void
    {
        $this->record(new CountryWasDeleteDomainEvent($this->uuid));
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

    public function toArray(): array
    {
        return [
            'uuid' => $this->uuid,
            'value' => $this->value->value,
            'iso' => $this->iso->value,
            'is_active' => $this->isActive,
            'company_uuid' => $this->companyUuid->value,
            'created_at' => $this->createdAt->getTimestamp(),
            'updated_at' => $this->updatedAt->getTimestamp(),
        ];
    }
}
