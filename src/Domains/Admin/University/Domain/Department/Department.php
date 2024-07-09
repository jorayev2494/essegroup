<?php

declare(strict_types=1);

namespace Project\Domains\Admin\University\Domain\Department;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Project\Domains\Admin\Currency\Domain\Currency\Currency;
use Project\Domains\Admin\Language\Domain\Language\Language;
use Project\Domains\Admin\Language\Domain\Language\LanguageTranslate;
use Project\Domains\Admin\University\Domain\Alias\Alias;
use Project\Domains\Admin\University\Domain\Alias\AliasTranslate;
use Project\Domains\Admin\University\Domain\Application\Application;
use Project\Domains\Admin\University\Domain\Degree\Degree;
use Project\Domains\Admin\University\Domain\Degree\DegreeTranslate;
use Project\Domains\Admin\University\Domain\Department\Events\ApplicationWasDeletedFromDepartmentDomainEvent;
use Project\Domains\Admin\University\Domain\Department\Events\DepartmentWasDeletedDomainEvent;
use Project\Domains\Admin\University\Domain\Department\Name\DepartmentName;
use Project\Domains\Admin\University\Domain\Department\Name\DepartmentNameTranslate;
use Project\Domains\Admin\University\Domain\Department\ValueObjects\Description;
use Project\Domains\Admin\University\Domain\Department\ValueObjects\DiscountPrice;
use Project\Domains\Admin\University\Domain\Department\ValueObjects\Price;
use Project\Domains\Admin\University\Domain\Department\ValueObjects\Uuid;
use Project\Domains\Admin\University\Domain\Faculty\Faculty;
use Project\Domains\Admin\University\Domain\Faculty\FacultyTranslate;
use Project\Domains\Admin\University\Domain\University\University;
use Project\Domains\Admin\University\Domain\University\UniversityTranslate;
use Project\Domains\Admin\University\Domain\University\ValueObjects\Name;
use Project\Domains\Admin\University\Infrastructure\Repositories\Doctrine\Department\Types\DescriptionType;
use Project\Domains\Admin\University\Infrastructure\Repositories\Doctrine\Department\Types\DiscountPriceType;
use Project\Domains\Admin\University\Infrastructure\Repositories\Doctrine\Department\Types\PriceType;
use Project\Domains\Admin\University\Infrastructure\Repositories\Doctrine\Department\Types\UuidType;
use Project\Shared\Domain\Aggregate\AggregateRoot;
use Project\Shared\Domain\Contracts\EntityUuid;
use Project\Shared\Domain\Traits\ActivableTrait;
use Project\Shared\Domain\Traits\CreatedAtAndUpdatedAtTrait;
use Project\Shared\Domain\Translation\AbstractTranslation;
use Project\Shared\Domain\Translation\DomainEvents\TranslationDomainEventTypeEnum;
use Project\Shared\Domain\Translation\TranslatableInterface;
use Project\Shared\Domain\Translation\TranslatableTrait;

#[ORM\Entity]
#[ORM\Table(name: 'university_departments')]
#[ORM\HasLifecycleCallbacks]
class Department extends AggregateRoot implements EntityUuid, TranslatableInterface
{
    use ActivableTrait,
        TranslatableTrait,
        CreatedAtAndUpdatedAtTrait;

    #[ORM\Id]
    #[ORM\Column(type: UuidType::NAME)]
    private Uuid $uuid;

    #[ORM\Column(name: 'name_uuid', nullable: true)]
    private string $nameUuid;

    #[ORM\ManyToOne(targetEntity: DepartmentName::class, inversedBy: 'departments')]
    #[ORM\JoinColumn(name: 'name_uuid', referencedColumnName: 'uuid', onDelete: 'SET NULL')]
    private DepartmentName $name;

    #[ORM\Column(type: DescriptionType::NAME, nullable: true)]
    private Description $description;

    #[ORM\OneToMany(targetEntity: DepartmentTranslation::class, mappedBy: 'object', cascade: ['persist', 'remove'], fetch: 'EAGER')]
    private Collection $translations;

    #[ORM\Column(name: 'alias_uuid', nullable: true)]
    private ?string $aliasUuid;

    #[ORM\ManyToOne(targetEntity: Alias::class, inversedBy: 'departments')]
    #[ORM\JoinColumn(name: 'alias_uuid', referencedColumnName: 'uuid', onDelete: 'SET NULL')]
    private Alias $alias;

    #[ORM\Column(name: 'university_uuid', type: Types::STRING, nullable: true)]
    private ?string $universityUuid;

    #[ORM\ManyToOne(targetEntity: University::class, inversedBy: 'departments')]
    #[ORM\JoinColumn(name: 'university_uuid', referencedColumnName: 'uuid', onDelete: 'SET NULL')]
    private University $university;

    #[ORM\Column(name: 'faculty_uuid', type: Types::STRING, nullable: true)]
    private ?string $facultyUuid;

    #[ORM\ManyToOne(targetEntity: Faculty::class, inversedBy: 'departments')]
    #[ORM\JoinColumn(name: 'faculty_uuid', referencedColumnName: 'uuid', onDelete: 'SET NULL')]
    private Faculty $faculty;

    #[ORM\Column(name: 'degree_uuid', nullable: true)]
    private ?string $degreeUuid;

    #[ORM\ManyToOne(targetEntity: Degree::class, inversedBy: 'departments')]
    #[ORM\JoinColumn(name: 'degree_uuid', referencedColumnName: 'uuid', onDelete: 'SET NULL')]
    private Degree $degree;

    #[ORM\Column(name: 'language_uuid', nullable: true)]
    private ?string $languageUuid;

    #[ORM\ManyToOne(targetEntity: Language::class, inversedBy: 'departments')]
    #[ORM\JoinColumn(name: 'language_uuid', referencedColumnName: 'uuid', onDelete: 'SET NULL')]
    private Language $language;

    #[ORM\ManyToMany(targetEntity: Application::class, mappedBy: 'departments')]
    private Collection $applications;

    #[ORM\Column(name: 'price', type: PriceType::NAME, length: 10, nullable: true)]
    private Price $price;

    #[ORM\Column(name: 'discount_price', type: DiscountPriceType::NAME, length: 10, nullable: true)]
    private DiscountPrice $discountPrice;

    #[ORM\Column(name: 'price_currency_uuid', nullable: true)]
    private ?string $priceCurrencyUuid;

    #[ORM\ManyToOne(targetEntity: Currency::class, inversedBy: 'departments')]
    #[ORM\JoinColumn(name: 'price_currency_uuid', referencedColumnName: 'uuid', onDelete: 'SET NULL')]
    private Currency $priceCurrency;

    #[ORM\Column(name: 'is_filled', type: Types::BOOLEAN)]
    private bool $isFilled;

    private function __construct(
        Uuid $uuid,
        DepartmentName $name,
        Alias $alias,
        University $university,
        Faculty $faculty,
        Degree $degree,
        Language $language,
        Price $price,
        Currency $priceCurrency,
        bool $isActive
    )

    {
        $this->uuid = $uuid;
        $this->name = $name;
        $this->alias = $alias;
        $this->university = $university;
        $this->faculty = $faculty;
        $this->degree = $degree;
        $this->language = $language;
        $this->price = $price;
        $this->priceCurrency = $priceCurrency;
        $this->discountPrice = DiscountPrice::fromValue(null);
        $this->description = Description::fromValue(null);
        $this->translations = new ArrayCollection();
        $this->applications = new ArrayCollection();
        $this->isActive = $isActive;
        $this->isFilled = false;
    }

    public static function create(
        Uuid $uuid,
        DepartmentName $name,
        Alias $alias,
        University $university,
        Faculty $faculty,
        Degree $degree,
        Language $language,
        Price $price,
        Currency $priceCurrency,
        bool $isActive
    ): self
    {
        return new self($uuid, $name, $alias, $university, $faculty, $degree, $language, $price, $priceCurrency, $isActive);
    }

    public function getUuid(): UUid
    {
        return $this->uuid;
    }

    public function getName(): DepartmentName
    {
        return $this->name;
    }

    public function getDescription(): Description
    {
        return $this->description;
    }

    public function setDescription(Description $description): void
    {
        $this->description = $description;
    }

    public function changeName(DepartmentName $name): self
    {
        if ($this->name->getUuid()->value !== $name->getUuid()->value) {
            $this->name = $name;
        }

        return $this;
    }

    public function getAlias(): Alias
    {
        return $this->alias;
    }

    public function changeAlias(Alias $alias): self
    {
        $this->alias = $alias;

        return $this;
    }

    public function getUniversity(): University
    {
        return $this->university;
    }

    public function changeUniversity(University $university): void
    {
        $this->university = $university;
    }

    public function getFaculty(): Faculty
    {
        return $this->faculty;
    }

    public function changeFaculty(Faculty $faculty): void
    {
        $this->faculty = $faculty;
    }

    public function getDegree(): Degree
    {
        return $this->degree;
    }

    public function changeDegree(Degree $degree): self
    {
        $this->degree = $degree;

        return $this;
    }

    public function addApplication(Application $application): self
    {
        if (! $this->applications->contains($application)) {
            $this->applications->add($application);
        }

        return $this;
    }

    public function getApplications(): Collection
    {
        return $this->applications;
    }

    public function getLanguage(): Language
    {
        return $this->language;
    }

    public function changeLanguage(Language $language): self
    {
        $this->language = $language;

        return $this;
    }

    public function removeApplication(Application $application): void
    {
        if ($this->applications->contains($application)) {
            $this->applications->removeElement($application);
            $this->record(new ApplicationWasDeletedFromDepartmentDomainEvent($this->getUuid()->value, $application->getUuid()->value));
        }
    }

    public function getIsActive(): bool
    {
        return $this->isActive;
    }

    public function setIsActive(bool $isActive): void
    {
        $this->isActive = $isActive;
    }

    public function translationDomainEvent(AbstractTranslation $translation, TranslationDomainEventTypeEnum $type): void
    {
//        $domainEvent = match ($type) {
//            TranslationDomainEventTypeEnum::ADDED => new UniversityTranslationWasAddedDomainEvent(
//                $this->uuid->value,
//                $translation->getLocale(),
//                $translation->getField(),
//                $translation->getContent()
//            ),
//            TranslationDomainEventTypeEnum::CHANGED => new UniversityTranslationWasChangedDomainEvent(
//                $this->uuid->value,
//                $translation->getLocale(),
//                $translation->getField(),
//                $translation->getContent()
//            ),
//            TranslationDomainEventTypeEnum::DELETED => new UniversityTranslationWasDeletedDomainEvent(
//                $this->uuid->value,
//                $translation->getLocale(),
//                $translation->getField()
//            ),
//        };
//
//        $this->record($domainEvent);
    }

    public function getTranslationClass(): string
    {
        return DepartmentTranslation::class;
    }

    public function changePrice(Price $price): self
    {
        if ($this->price->isNotEquals($price)) {
            $this->price = $price;
        }

        return $this;
    }

    public function changeDiscountPrice(DiscountPrice $discountPrice): self
    {
        if ($this->discountPrice->isNotEquals($discountPrice)) {
            $this->discountPrice = $discountPrice;
        }

        return $this;
    }

    public function changePriceCurrency(Currency $priceCurrency): self
    {
        if ($priceCurrency->isNotEquals($priceCurrency)) {
            $this->priceCurrency = $priceCurrency;
        }

        return $this;
    }

    public function getIsFilled(): bool
    {
       return $this->isFilled;
    }

    public function changeIsFilled(bool $isFilled): self
    {
        if ($this->isFilled !== $isFilled) {
            $this->isFilled = $isFilled;
        }

        return $this;
    }

    public function delete(): void
    {
        $this->record(new DepartmentWasDeletedDomainEvent($this->uuid->value));
    }

    #[\Override]
    public function toArray(): array
    {
        return [
            'uuid' => $this->uuid->value,
            'name_uuid' => DepartmentNameTranslate::execute($this->name)?->getUuid()->value,
            'name' => DepartmentNameTranslate::execute($this->name)?->toArray(),
            'description' => $this->description->value,
            'alias_uuid' => $this->aliasUuid,
            'alias' => AliasTranslate::execute($this->alias)?->toArray(),
            'university_uuid' => $this->universityUuid,
            'university' => UniversityTranslate::execute($this->university)?->toArray(),
            'faculty_uuid' => $this->facultyUuid,
            'faculty' => FacultyTranslate::execute($this->faculty)?->toArray(),
            'degree_uuid' => $this->degreeUuid,
            'degree' => DegreeTranslate::execute($this->degree)?->toArray(),
            'language_uuid' => $this->languageUuid,
            'language' => LanguageTranslate::execute($this->language)?->toArray(),
            'price' => $this->price->value,
            'discount_price' => $this->discountPrice->value,
            'price_currency_uuid' => $this->priceCurrencyUuid,
            'price_currency' => $this->priceCurrency->getUuid()->isNotNull() ? $this->priceCurrency->toArray() : null,
            'is_filled' => $this->isFilled,
            'is_active' => $this->isActive,
            'created_at' => $this->createdAt->getTimestamp(),
            'updated_at' => $this->updatedAt->getTimestamp(),
        ];
    }
}
