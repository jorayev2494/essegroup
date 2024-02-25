<?php

declare(strict_types=1);

namespace Project\Domains\Admin\University\Domain\Faculty;

use DateTimeImmutable;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Event\PrePersistEventArgs;
use Doctrine\ORM\Event\PreUpdateEventArgs;
use Doctrine\ORM\Mapping as ORM;
use Project\Domains\Admin\University\Domain\Application\Application;
use Project\Domains\Admin\University\Domain\Department\Department;
use Project\Domains\Admin\University\Domain\Faculty\ValueObjects\Description;
use Project\Domains\Admin\University\Domain\Faculty\ValueObjects\Logo;
use Project\Domains\Admin\University\Domain\Faculty\ValueObjects\Name;
use Project\Domains\Admin\University\Domain\Faculty\ValueObjects\Uuid;
use Project\Domains\Admin\University\Domain\University\University;
use Project\Domains\Admin\University\Infrastructure\Repositories\Doctrine\Faculty\Types\DescriptionType;
use Project\Domains\Admin\University\Infrastructure\Repositories\Doctrine\Faculty\Types\NameType;
use Project\Domains\Admin\University\Infrastructure\Repositories\Doctrine\Faculty\Types\UuidType;
use Project\Domains\Admin\University\Infrastructure\Services\Media\Logo\Contracts\LogoableInterface;
use Project\Domains\Admin\University\Infrastructure\Services\Media\Logo\Contracts\LogoInterface;
use Project\Shared\Domain\Aggregate\AggregateRoot;
use Project\Shared\Domain\Translation\AbstractTranslation;
use Project\Shared\Domain\Translation\DomainEvents\TranslationDomainEventTypeEnum;
use Project\Shared\Domain\Translation\TranslatableInterface;
use Project\Shared\Domain\Translation\TranslatableTrait;

#[ORM\Entity]
#[ORM\Table('faculty_faculties')]
#[ORM\HasLifecycleCallbacks]
class Faculty extends AggregateRoot implements TranslatableInterface, LogoableInterface
{
    use TranslatableTrait;

    #[ORM\Id]
    #[ORM\Column(type: UuidType::NAME)]
    private Uuid $uuid;

    #[ORM\OneToOne(targetEntity: Logo::class, inversedBy: 'faculty', cascade: ['persist', 'remove'])]
    #[ORM\JoinColumn(name: 'logo_uuid', referencedColumnName: 'uuid', unique: true, nullable: false)]
    private ?Logo $logo;

    #[ORM\Column(type: NameType::NAME, nullable: true)]
    private Name $name;

    #[ORM\Column(type: DescriptionType::NAME, nullable: true)]
    private Description $description;

    #[ORM\OneToMany(targetEntity: FacultyTranslation::class, mappedBy: 'object', cascade: ['persist', 'remove'], fetch: 'EAGER')]
    private Collection $translations;

    #[ORM\Column(name: 'university_uuid')]
    private string $universityUuid;

    #[ORM\ManyToOne(targetEntity: University::class, inversedBy: 'faculties')]
    #[ORM\JoinColumn(name: 'university_uuid', referencedColumnName: 'uuid', nullable: false)]
    private University $university;

    #[ORM\OneToMany(targetEntity: Department::class, mappedBy: 'faculty', cascade: ['persist', 'remove'])]
    private Collection $departments;

    #[ORM\OneToMany(targetEntity: Application::class, mappedBy: 'countries')]
    private Collection $applications;

    #[ORM\Column(name: 'is_active')]
    private bool $isActive;

    #[ORM\Column(name: 'created_at', type: Types::DATETIME_IMMUTABLE)]
    protected DateTimeImmutable $createdAt;

    #[ORM\Column(name: 'updated_at', type: Types::DATETIME_IMMUTABLE)]
    protected DateTimeImmutable $updatedAt;

    private function __construct(Uuid $uuid, bool $isActive)
    {
        $this->uuid = $uuid;
        $this->name = Name::fromValue(null);
        $this->description = Description::fromValue(null);
        $this->logo = null;
        $this->departments = new ArrayCollection();
        $this->isActive = $isActive;
        $this->translations = new ArrayCollection();
    }

    public function getUuid(): Uuid
    {
        return $this->uuid;
    }

    public function getName(): ?Name
    {
        return $this->name;
    }

    public function setName(Name $name): void
    {
        $this->name = $name;
    }

    public function getDescription(): ?Description
    {
        return $this->description;
    }

    public function setDescription(Description $description): void
    {
        $this->description = $description;
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

    public function getTranslations(): Collection
    {
        return $this->translations;
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

    public function getUniversity(): University
    {
        return $this->university;
    }

    public function setUniversity(University $university): void
    {
        $this->university = $university;
    }

    public static function create(Uuid $uuid, bool $isActive): self
    {
        return new self($uuid, $isActive);
    }

    public function addDepartments(Department $department): void
    {
        if (! $this->departments->contains($department)) {
            $this->departments->add($department);
            $department->setFaculty($this);
        }
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

    public function changeUniversityUuid(string $uuid): void
    {
        if ($this->universityUuid !== $uuid) {
            $this->universityUuid = $uuid;
        }
    }

    public function changeIsActive(bool $value): void
    {
        if ($this->isActive !== $value) {
            $this->isActive = $value;
        }
    }

    #[\Override]
    public function deleteLogo(): static
    {
        if ($this->logo !== null) {
            $this->logo = null;
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

    #[\Override]
    public function toArray(): array
    {
        return [
            'uuid' => $this->uuid->value,
            'name' => $this->name->value,
            'university_uuid' => $this->universityUuid,
            'logo' => $this->logo?->toArray(),
            'description' => $this->description->value,
            'is_active' => $this->isActive,
            'created_at' => $this->createdAt->getTimestamp(),
            'updated_at' => $this->updatedAt->getTimestamp(),
        ];
    }
}
