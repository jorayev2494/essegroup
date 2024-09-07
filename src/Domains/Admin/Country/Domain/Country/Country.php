<?php

declare(strict_types=1);

namespace Project\Domains\Admin\Country\Domain\Country;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Project\Domains\Admin\Country\Domain\City\City;
use Project\Domains\Admin\Country\Domain\Country\Events\CountryWasChangedIsActiveDomainEvent;
use Project\Domains\Admin\Country\Domain\Country\Events\CountryWasChangedISODomainEvent;
use Project\Domains\Admin\Country\Domain\Country\Events\CountryWasChangedValueDomainEvent;
use Project\Domains\Admin\Country\Domain\Country\Events\CountryWasCreatedDomainEvent;
use Project\Domains\Admin\Country\Domain\Country\ValueObjects\ISO;
use Project\Domains\Admin\Country\Domain\Country\ValueObjects\Uuid;
use Project\Domains\Admin\Country\Domain\Country\ValueObjects\Value;
use Project\Domains\Admin\Country\Infrastructure\Country\Repositories\Doctrine\Types\ISOType;
use Project\Domains\Admin\Country\Infrastructure\Country\Repositories\Doctrine\Types\ValueType;
use Project\Domains\Admin\Country\Infrastructure\Country\Repositories\Doctrine\Types\UuidType;
use Project\Domains\Admin\University\Domain\Application\Application;
use Project\Domains\Admin\University\Domain\University\University;
use Project\Shared\Contracts\ArrayableInterface;
use Project\Shared\Contracts\NullableInterface;
use Project\Shared\Domain\Aggregate\AggregateRoot;
use Project\Shared\Domain\Contracts\EntityUuid;
use Project\Shared\Domain\Traits\ActivableTrait;
use Project\Shared\Domain\Traits\CreatedAtAndUpdatedAtTrait;
use Project\Shared\Domain\Translation\TranslatableInterface;
use Project\Shared\Domain\Translation\TranslatableTrait;

#[ORM\Entity]
#[ORM\Table(name: 'country_countries')]
#[ORM\HasLifecycleCallbacks]
class Country extends AggregateRoot implements EntityUuid, TranslatableInterface, NullableInterface, ArrayableInterface
{
    use TranslatableTrait,
        ActivableTrait,
        CreatedAtAndUpdatedAtTrait;

    #[ORM\Id]
    #[ORM\Column(type: UuidType::NAME)]
    private Uuid $uuid;

    #[ORM\Column(name: 'value', type: ValueType::NAME, nullable: true)]
    private Value $value;

    #[ORM\Column(name: 'iso', type: ISOType::NAME, length: 3)]
    private ISO $iso;

//    #[ORM\OneToMany(targetEntity: University::class, mappedBy: 'country')]
//    private Collection $universities;

    /**
     * @var CountryTranslation[] $translations
     */
    #[ORM\OneToMany(targetEntity: CountryTranslation::class, mappedBy: 'object', cascade: ['persist', 'remove'], fetch: 'EAGER')]
    private Collection $translations;

    #[ORM\OneToMany(targetEntity: City::class, mappedBy: 'country', cascade: ['persist', 'remove'])]
    private Collection $cities;

    #[ORM\OneToMany(targetEntity: University::class, mappedBy: 'country')]
    private Collection $universities;

    #[ORM\OneToMany(targetEntity: Application::class, mappedBy: 'country')]
    private Collection $applications;

    private function __construct(Uuid $uuid, ISO $iso, bool $isActive)
    {
        $this->uuid = $uuid;
        $this->value = Value::fromValue(null);
        $this->translations = new ArrayCollection();
        $this->iso = $iso;
        $this->cities = new ArrayCollection();
        $this->isActive = $isActive;
    }

    public static function create(Uuid $uuid, ISO $iso, bool $isActive): self
    {
        $country = new self($uuid, $iso, $isActive);
        $country->record(
            new CountryWasCreatedDomainEvent(
                $country->uuid->value,
                $country->iso->value,
                $country->isActive
            )
        );

        return $country;
    }

    public function getUuid(): Uuid
    {
        return $this->uuid;
    }

    public function getValue(): Value
    {
        return $this->value;
    }

    public function setValue(Value $value): self
    {
        $this->value = $value;

        return $this;
    }

    public function changeValue(Value $value): void
    {
        if ($this->value->isNotEquals($value)) {
            $this->value = $value;
            $this->record(
                new CountryWasChangedValueDomainEvent(
                    $this->uuid->value,
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
                    $this->uuid->value,
                    $this->iso->value
                )
            );
        }
    }

    public function getCities(): Collection
    {
        return $this->cities;
    }

    public function addCity(City $city): self
    {
        if (! $this->cities->contains($city)) {
            $this->cities->add($city);
            $city->setCountry($this);
        }

        return $this;
    }

    public function changeIsActive(bool $isActive): void
    {
        if ($this->isActive !== $isActive) {
            $this->isActive = $isActive;
            $this->record(
                new CountryWasChangedIsActiveDomainEvent(
                    $this->uuid->value,
                    $this->isActive,
                )
            );
        }
    }

    public function delete(): void
    {
        // $this->record(new CountryWasDeleteDomainEvent($this->uuid));
    }

    public function isEquals(self $other): bool
    {
        return $this->uuid->value === $other->uuid->value;
    }

    public function isNotEquals(self $other): bool
    {
        return $this->uuid->value !== $other->uuid->value;
    }

    public function getTranslationClass(): string
    {
        return CountryTranslation::class;
    }

    public function toArray(): array
    {
        return [
            'uuid' => $this->uuid->value,
            'value' => $this->value->value,
            'iso' => $this->iso->value,
            'is_active' => $this->isActive,
            'created_at' => $this->createdAt->getTimestamp(),
            'updated_at' => $this->updatedAt->getTimestamp(),
        ];
    }

    public function isNull(): bool
    {
        return is_null($this->uuid);
    }

    public function isNotNull(): bool
    {
        return ! is_null($this->uuid);
    }
}
