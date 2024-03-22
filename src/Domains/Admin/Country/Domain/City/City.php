<?php

declare(strict_types=1);

namespace Project\Domains\Admin\Country\Domain\City;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Project\Domains\Admin\Country\Domain\City\ValueObjects\CompanyUuid;
use Project\Domains\Admin\Country\Domain\City\ValueObjects\Uuid;
use Project\Domains\Admin\Country\Domain\City\ValueObjects\Value;
use Project\Domains\Admin\Country\Domain\Country\Country;
use Project\Domains\Admin\Country\Infrastructure\City\Repositories\Doctrine\Types\CompanyUuidType;
use Project\Domains\Admin\Country\Infrastructure\City\Repositories\Doctrine\Types\ValueType;
use Project\Domains\Admin\Country\Infrastructure\City\Repositories\Doctrine\Types\UuidType;
use Project\Shared\Contracts\ArrayableInterface;
use Project\Shared\Domain\Traits\ActivableTrait;
use Project\Shared\Domain\Traits\CreatedAtAndUpdatedAtTrait;
use Project\Shared\Domain\Translation\AbstractTranslation;
use Project\Shared\Domain\Translation\DomainEvents\TranslationDomainEventTypeEnum;
use Project\Shared\Domain\Translation\TranslatableInterface;
use Project\Shared\Domain\Translation\TranslatableTrait;

#[ORM\Entity]
#[ORM\Table(name: 'country_cities')]
#[ORM\HasLifecycleCallbacks]
class City implements ArrayableInterface, TranslatableInterface
{
    use ActivableTrait,
        CreatedAtAndUpdatedAtTrait,
        TranslatableTrait;

    #[ORM\Id]
    #[ORM\Column(type: UuidType::NAME)]
    private Uuid $uuid;

    #[ORM\Column(type: ValueType::NAME, nullable: true)]
    private Value $value;

    #[ORM\Column(name: 'company_uuid', type: CompanyUuidType::NAME, nullable: false)]
    private CompanyUuid $companyUuid;

    #[ORM\ManyToOne(targetEntity: Country::class, inversedBy: 'cities')]
    #[ORM\JoinColumn(name: 'country_uuid', referencedColumnName: 'uuid')]
    private Country $country;

    /**
     * @var CityTranslation[] $translations
     */
    #[ORM\OneToMany(targetEntity: CityTranslation::class, mappedBy: 'object', cascade: ['persist', 'remove'], fetch: 'EAGER')]
    private Collection $translations;

    private function __construct(Uuid $uuid, CompanyUuid $companyUuid, bool $isActive)
    {
        $this->uuid = $uuid;
        $this->companyUuid = $companyUuid;
        $this->value = new Value(null);
        $this->translations = new ArrayCollection();
        $this->isActive = $isActive;
    }

    public static function fromPrimitives(string $uuid, string $companyUuid, bool $isActive): self
    {
        return new self(
            Uuid::fromValue($uuid),
            CompanyUuid::fromValue($companyUuid),
            $isActive
        );
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

    public function changeCompanyUuid(CompanyUuid $companyUuid): self
    {
        if ($this->companyUuid->isNotEquals($companyUuid)) {
            $this->companyUuid = $companyUuid;
        }

        return $this;
    }

    public function getCountry(): Country
    {
        return $this->country;
    }

    public function setCountry(Country $country): self
    {
        $this->country = $country;

        return $this;
    }

    public function getTranslationClass(): string
    {
        return CityTranslation::class;
    }

    public function translationDomainEvent(AbstractTranslation $translation, TranslationDomainEventTypeEnum $type): void
    {
        // $domainEvent = match ($type) {
        //     TranslationDomainEventTypeEnum::ADDED => new UniversityTranslationWasAddedDomainEvent(
        //         $this->uuid->value,
        //         $translation->getLocale(),
        //         $translation->getField(),
        //         $translation->getContent()
        //     ),
        //     TranslationDomainEventTypeEnum::CHANGED => new UniversityTranslationWasChangedDomainEvent(
        //         $this->uuid->value,
        //         $translation->getLocale(),
        //         $translation->getField(),
        //         $translation->getContent()
        //     ),
        //     TranslationDomainEventTypeEnum::DELETED => new UniversityTranslationWasDeletedDomainEvent(
        //         $this->uuid->value,
        //         $translation->getLocale(),
        //         $translation->getField()
        //     ),
        // };
        //
        // $this->record($domainEvent);
    }

    public function toArray(): array
    {
        return [
            'uuid' => $this->uuid->value,
            'value' => $this->value->value,
            'company_uuid' => $this->companyUuid->value,
            'country_uuid' => $this->country->getUuid(),
            'country' => $this->country->toArray(),
            'is_active' => $this->isActive,
            'created_at' => $this->createdAt->getTimestamp(),
            'updated_at' => $this->updatedAt->getTimestamp(),
        ];
    }
}
