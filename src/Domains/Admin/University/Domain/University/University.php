<?php

declare(strict_types=1);

namespace Project\Domains\Admin\University\Domain\University;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Project\Domains\Admin\Country\Domain\City\City;
use Project\Domains\Admin\Country\Domain\City\CityTranslate;
use Project\Domains\Admin\Country\Domain\Country\Country;
use Project\Domains\Admin\Country\Domain\Country\CountryTranslate;
use Project\Domains\Admin\University\Domain\Application\Application;
use Project\Domains\Admin\University\Domain\Department\Department;
use Project\Domains\Admin\University\Domain\Faculty\Faculty;
use Project\Domains\Admin\University\Domain\University\Events\Translation\UniversityTranslationWasAddedDomainEvent;
use Project\Domains\Admin\University\Domain\University\Events\Translation\UniversityTranslationWasChangedDomainEvent;
use Project\Domains\Admin\University\Domain\University\Events\Translation\UniversityTranslationWasDeletedDomainEvent;
use Project\Domains\Admin\University\Domain\University\Events\UniversityCityWasChangedDomainEvent;
use Project\Domains\Admin\University\Domain\University\Events\UniversityCountryWasChangedDomainEvent;
use Project\Domains\Admin\University\Domain\University\Events\UniversityWasCreatedDomainEvent;
use Project\Domains\Admin\University\Domain\University\Events\UniversityWasDeletedDomainEvent;
use Project\Domains\Admin\University\Domain\University\ValueObjects\Cover;
use Project\Domains\Admin\University\Domain\University\ValueObjects\Description;
use Project\Domains\Admin\University\Domain\University\ValueObjects\Label;
use Project\Domains\Admin\University\Domain\University\ValueObjects\Logo;
use Project\Domains\Admin\University\Domain\University\ValueObjects\Name;
use Project\Domains\Admin\University\Domain\University\ValueObjects\Uuid;
use Project\Domains\Admin\University\Domain\University\ValueObjects\YouTubeVideoId;
use Project\Domains\Admin\University\Infrastructure\Repositories\Doctrine\University\Types\DescriptionType;
use Project\Domains\Admin\University\Infrastructure\Repositories\Doctrine\University\Types\LabelType;
use Project\Domains\Admin\University\Infrastructure\Repositories\Doctrine\University\Types\NameType;
use Project\Domains\Admin\University\Infrastructure\Repositories\Doctrine\University\Types\UuidType;
use Project\Domains\Admin\University\Infrastructure\Repositories\Doctrine\University\Types\YouTubeVideoIdType;
use Project\Domains\Admin\University\Infrastructure\Services\Media\Cover\Contracts\CoverableInterface;
use Project\Domains\Admin\University\Infrastructure\Services\Media\Cover\Contracts\CoverInterface;
use Project\Domains\Admin\University\Infrastructure\Services\Media\Logo\Contracts\LogoableInterface;
use Project\Domains\Admin\University\Infrastructure\Services\Media\Logo\Contracts\LogoInterface;
use Project\Shared\Domain\Aggregate\AggregateRoot;
use Project\Shared\Domain\Contracts\EntityUuid;
use Project\Shared\Domain\Traits\CreatedAtAndUpdatedAtTrait;
use Project\Shared\Domain\Translation\AbstractTranslation;
use Project\Shared\Domain\Translation\DomainEvents\TranslationDomainEventTypeEnum;
use Project\Shared\Domain\Translation\TranslatableInterface;
use Project\Shared\Domain\Translation\TranslatableTrait;

#[ORM\Entity]
#[ORM\Table(name: 'university_universities')]
#[ORM\HasLifecycleCallbacks]
class University extends AggregateRoot implements EntityUuid, TranslatableInterface, LogoableInterface, CoverableInterface
{
    use CreatedAtAndUpdatedAtTrait,
        TranslatableTrait;

    #[ORM\Id]
    #[ORM\Column(type: UuidType::NAME)]
    private Uuid $uuid;

    #[ORM\Column(name: 'youtube_video_id', type: YouTubeVideoIdType::NAME, nullable: true)]
    private YouTubeVideoId $youTubeVideoId;

    #[ORM\OneToOne(targetEntity: Logo::class, inversedBy: 'university', cascade: ['persist', 'remove'])]
    #[ORM\JoinColumn(name: 'logo_uuid', referencedColumnName: 'uuid', unique: true, nullable: true)]
    private ?Logo $logo;

    #[ORM\OneToOne(targetEntity: Cover::class, inversedBy: 'university', cascade: ['persist', 'remove'])]
    #[ORM\JoinColumn(name: 'cover_uuid', referencedColumnName: 'uuid', unique: true, nullable: true)]
    private ?Cover $cover;

    #[ORM\Column(type: NameType::NAME, nullable: true)]
    private Name $name;

    #[ORM\Column(type: LabelType::NAME, nullable: true)]
    private Label $label;

    #[ORM\Column(type: DescriptionType::NAME, nullable: true)]
    private Description $description;

    #[ORM\Column(name: 'country_uuid', nullable: true)]
    private ?string $countryUuid;

    #[ORM\ManyToOne(targetEntity: Country::class, inversedBy: 'universities')]
    #[ORM\JoinColumn(name: 'country_uuid', referencedColumnName: 'uuid', onDelete: 'SET NULL')]
    private Country $country;

    #[ORM\Column(name: 'city_uuid', nullable: true)]
    private ?string $cityUuid;

    #[ORM\ManyToOne(targetEntity: City::class, inversedBy: 'universities')]
    #[ORM\JoinColumn(name: 'city_uuid', referencedColumnName: 'uuid', onDelete: 'SET NULL')]
    private ?City $city;

    /**
     * @var UniversityTranslation[] $translations
     */
    #[ORM\OneToMany(targetEntity: UniversityTranslation::class, mappedBy: 'object', cascade: ['persist', 'remove'], fetch: 'EAGER')]
    private Collection $translations;

    #[ORM\OneToMany(targetEntity: Faculty::class, mappedBy: 'university')]
    private Collection $faculties;

    #[ORM\OneToMany(targetEntity: Department::class, mappedBy: 'university')]
    private Collection $departments;

    #[ORM\OneToMany(targetEntity: Application::class, mappedBy: 'universities')]
    private Collection $applications;

    #[ORM\Column(name: 'is_on_the_country_list', type: Types::BOOLEAN, options: ['default' => false])]
    private bool $isOnTheCountryList;

    private function __construct(Uuid $uuid, Country $country, City $city, YouTubeVideoId $youTubeVideoId)
    {
        $this->uuid = $uuid;
        $this->country = $country;
        $this->city = $city;
        $this->youTubeVideoId = $youTubeVideoId;
        $this->name = Name::fromValue(null);
        $this->label = Label::fromValue(null);
        $this->description = Description::fromValue(null);
        $this->logo = null;
        $this->cover = null;
        $this->faculties = new ArrayCollection();
        $this->translations = new ArrayCollection();
        $this->isOnTheCountryList = false;
    }

    public static function create(Uuid $uuid, Country $country, City $city, YouTubeVideoId $youTubeVideoId): self
    {
        $university = new self($uuid, $country, $city, $youTubeVideoId);
        $university->record(
            new UniversityWasCreatedDomainEvent(
                $university->getUuid()->value,
                $university->getCountry()->getUuid()->value,
                $university->getCity()->getUuid()->value,
                $university->getYouTubeVideoId()->value
            )
        );

        return $university;
    }

    public function delete(): void
    {
        $this->record(new UniversityWasDeletedDomainEvent($this->uuid->value));
    }

    public function getUuid(): Uuid
    {
        return $this->uuid;
    }

    public function getCountry(): Country
    {
        return $this->country;
    }

    public function changeCountry(Country $country): self
    {
        if ($this->country->isNotEquals($country)) {
            $this->country = $country;
            $this->record(
                new UniversityCountryWasChangedDomainEvent(
                    $this->uuid->value,
                    $this->getCountry()->getUuid()->value
                )
            );
        }

        return $this;
    }

    public function getCity(): City
    {
        return $this->city;
    }

    public function changeCity(City $city): self
    {
        if ($this->city->isNotEquals($city)) {
            $this->city = $city;
            $this->record(
                new UniversityCityWasChangedDomainEvent(
                    $this->uuid->value,
                    $this->city->getUuid()->value
                )
            );
        }

        return $this;
    }

    public function getYouTubeVideoId(): YouTubeVideoId
    {
        return $this->youTubeVideoId;
    }

    public function changeYouTubeVideoId(YouTubeVideoId $youTubeVideoId): void
    {
        if ($this->youTubeVideoId->isNotEquals($youTubeVideoId)) {
            $this->youTubeVideoId = $youTubeVideoId;
        }
    }

    public function setName(Name $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getName(): Name
    {
        return $this->name;
    }

    public function setLabel(Label $label): self
    {
        $this->label = $label;

        return $this;
    }

    public function setDescription(Description $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getLogo(): ?LogoInterface
    {
        return $this->logo;
    }

    public function setLogo(?LogoInterface $logo): static
    {
        if ($this->logo !== $logo) {
            $this->logo = $logo;
        }

        return $this;
    }

    public function translationDomainEvent(AbstractTranslation $translation, TranslationDomainEventTypeEnum $type): void
    {
        $domainEvent = match ($type) {
            TranslationDomainEventTypeEnum::ADDED => new UniversityTranslationWasAddedDomainEvent(
                $this->uuid->value,
                $translation->getLocale(),
                $translation->getField(),
                $translation->getContent()
            ),
            TranslationDomainEventTypeEnum::CHANGED => new UniversityTranslationWasChangedDomainEvent(
                $this->uuid->value,
                $translation->getLocale(),
                $translation->getField(),
                $translation->getContent()
            ),
            TranslationDomainEventTypeEnum::DELETED => new UniversityTranslationWasDeletedDomainEvent(
                $this->uuid->value,
                $translation->getLocale(),
                $translation->getField()
            ),
        };

        $this->record($domainEvent);
    }

    #[\Override]
    public function getLogoClassName(): string
    {
        return Logo::class;
    }

    #[\Override]
    public function changeLogo(?LogoInterface $logo): static
    {
        if ($this->logo !== $logo) {
            $this->logo = $logo;
        }

        return $this;
    }

    #[\Override]
    public function deleteLogo(): static
    {
//        if ($this->logo !== null) {
//            $this->logo = null;
//        }

        return $this;
    }

    #[\Override]
    public function getCover(): ?CoverInterface
    {
        return $this->cover;
    }

    public function setCover(?CoverInterface $cover): static
    {
        if ($this->cover !== $cover) {
            $this->cover = $cover;
        }

        return $this;
    }

    #[\Override]
    public function changeCover(?CoverInterface $cover): static
    {
        if ($this->cover !== $cover) {
            $this->cover = $cover;
        }

        return $this;
    }

    #[\Override]
    public function deleteCover(): static
    {
        // $this->cover = null;

        return $this;
    }

    public function isEquals(self $other): bool
    {
        return $this->uuid === $other->uuid;
    }

    public function isNotEquals(self $other): bool
    {
        return $this->uuid !== $other->uuid;
    }

    public function getTranslationClass(): string
    {
        return UniversityTranslation::class;
    }

    public function getIsOnTheCountryList(): bool
    {
        return $this->isOnTheCountryList;
    }

    public function setIsOnTheCountryList(bool $isOnTheCountryList): self
    {
        $this->isOnTheCountryList = $isOnTheCountryList;

        return $this;
    }

    public function changeIsOnTheCountryList(bool $isOnTheCountryList): self
    {
        if ($this->isOnTheCountryList !== $isOnTheCountryList) {
            $this->setIsOnTheCountryList($isOnTheCountryList);
        }

        return $this;
    }

    /**
     * @inheritDoc
     */
    #[\Override]
    public function toArray(): array
    {
        return [
            'uuid' => $this->uuid->value,
            'name' => $this->name->value,
            'label' => $this->label->value,
            'logo' => $this->logo?->toArray(),
            'cover' => $this->cover?->toArray(),
            'youtube_video_id' => $this->youTubeVideoId->value,
            'country_uuid' => $this->country->getUuid()->value,
            'country' => CountryTranslate::execute($this->country)?->toArray(),
            'city_uuid' => $this->city->getUuid()->value,
            'city' => CityTranslate::execute($this->city)?->toArray(),
            'description' => $this->description->value,
            'is_on_the_country_list' => $this->isOnTheCountryList,
            'created_at' => $this->createdAt->getTimestamp(),
            'updated_at' => $this->updatedAt->getTimestamp(),
        ];
    }
}
