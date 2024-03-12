<?php

declare(strict_types=1);

namespace Project\Domains\Admin\University\Domain\University;

use DateTimeImmutable;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Event\PrePersistEventArgs;
use Doctrine\ORM\Event\PreUpdateEventArgs;
use Doctrine\ORM\Mapping as ORM;
use Project\Domains\Admin\University\Domain\Application\Application;
use Project\Domains\Admin\University\Domain\Company\Company;
use Project\Domains\Admin\University\Domain\Faculty\Faculty;
use Project\Domains\Admin\University\Domain\University\Events\Translation\UniversityTranslationWasAddedDomainEvent;
use Project\Domains\Admin\University\Domain\University\Events\Translation\UniversityTranslationWasChangedDomainEvent;
use Project\Domains\Admin\University\Domain\University\Events\Translation\UniversityTranslationWasDeletedDomainEvent;
use Project\Domains\Admin\University\Domain\University\Events\UniversityWasCreatedDomainEvent;
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
use Project\Shared\Domain\Translation\AbstractTranslation;
use Project\Shared\Domain\Translation\DomainEvents\TranslationDomainEventTypeEnum;
use Project\Shared\Domain\Translation\TranslatableInterface;
use Project\Shared\Domain\Translation\TranslatableTrait;

#[ORM\Entity]
#[ORM\Table('university_universities')]
#[ORM\HasLifecycleCallbacks]
class University extends AggregateRoot implements TranslatableInterface, LogoableInterface, CoverableInterface
{
    use TranslatableTrait;

    #[ORM\Id]
    #[ORM\Column(type: UuidType::NAME)]
    private Uuid $uuid;

    #[ORM\Column(name: 'youtube_video_id', type: YouTubeVideoIdType::NAME, nullable: true)]
    private YouTubeVideoId $youTubeVideoId;

    #[ORM\OneToOne(targetEntity: Logo::class, inversedBy: 'university', cascade: ['persist', 'remove'], orphanRemoval: true)]
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

    #[ORM\Column(name: 'company_uuid')]
    private string $companyUuid;

    #[ORM\ManyToOne(targetEntity: Company::class, inversedBy: 'universities')]
    #[ORM\JoinColumn(name: 'company_uuid', referencedColumnName: 'uuid', nullable: false)]
    private ?Company $company;

    #[ORM\OneToMany(targetEntity: Faculty::class, mappedBy: 'university', cascade: ['persist', 'remove'])]
    private Collection $faculties;

    /**
     * @var UniversityTranslation[] $translations
     */
    #[ORM\OneToMany(targetEntity: UniversityTranslation::class, mappedBy: 'object', cascade: ['persist', 'remove'], fetch: 'EAGER')]
    private Collection $translations;

    #[ORM\OneToMany(targetEntity: Application::class, mappedBy: 'universities')]
    private Collection $applications;

    #[ORM\Column(name: 'created_at', type: Types::DATETIME_IMMUTABLE)]
    protected DateTimeImmutable $createdAt;

    #[ORM\Column(name: 'updated_at', type: Types::DATETIME_IMMUTABLE)]
    protected DateTimeImmutable $updatedAt;

    private function __construct(Uuid $uuid, YouTubeVideoId $youTubeVideoId)
    {
        $this->uuid = $uuid;
        $this->youTubeVideoId = $youTubeVideoId;
        $this->name = Name::fromValue(null);
        $this->label = Label::fromValue(null);
        $this->description = Description::fromValue(null);
        $this->logo = null;
        $this->cover = null;
        $this->translations = new ArrayCollection();
        $this->faculties = new ArrayCollection();
    }

    public static function create(Uuid $uuid, YouTubeVideoId $youTubeVideoId): self
    {
        $university = new self($uuid, $youTubeVideoId);
        $university->record(
            new UniversityWasCreatedDomainEvent(
                $university->getUuid()->value,
                $university->getYouTubeVideoId()->value
            )
        );

        return $university;
    }

    public function getUuid(): Uuid
    {
        return $this->uuid;
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

    public function getCompany(): Company
    {
        return $this->company;
    }

    public function setCompany(?Company $company): self
    {
        $this->company = $company;

        return $this;
    }

    public function getTranslations(): Collection
    {
        return $this->translations;
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
        if ($this->logo !== null) {
            $this->logo = null;
        }

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

    public function addFaculty(Faculty $faculty): void
    {
        if (! $this->faculties->contains($faculty)) {
            $this->faculties->add($faculty);
            $faculty->setUniversity($this);
        }
    }

    public function removeFaculty(Faculty $faculty): void
    {
        if ($this->faculties->contains($faculty)) {
            $this->faculties->removeElement($faculty);
        }
    }

    #[\Override]
    public function deleteCover(): static
    {
        if ($this->cover !== null) {
            $this->cover = null;
        }

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

    #[ORM\PrePersist]
    public function prePersist(PrePersistEventArgs $event): void
    {
        $this->createdAt = new DateTimeImmutable();
        $this->updatedAt = new DateTimeImmutable();
    }

    #[ORM\PreUpdate]
    public function preUpdate(PreUpdateEventArgs $event): void
    {
        $this->updatedAt = new DateTimeImmutable();
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
            'company_uuid' => $this->company->getUuid()->value,
            'company' => $this->company->toArray(),
            'description' => $this->description->value,
            'created_at' => $this->createdAt->getTimestamp(),
            'updated_at' => $this->updatedAt->getTimestamp(),
        ];
    }
}
