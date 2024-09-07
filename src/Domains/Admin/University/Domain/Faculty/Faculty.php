<?php

declare(strict_types=1);

namespace Project\Domains\Admin\University\Domain\Faculty;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Project\Domains\Admin\University\Domain\Department\Department;
use Project\Domains\Admin\University\Domain\Faculty\Events\FacultyWasDeletedDomainEvent;
use Project\Domains\Admin\University\Domain\Faculty\Name\FacultyName;
use Project\Domains\Admin\University\Domain\Faculty\Name\FacultyNameTranslate;
use Project\Domains\Admin\University\Domain\Faculty\ValueObjects\Description;
use Project\Domains\Admin\University\Domain\Faculty\ValueObjects\Logo;
use Project\Domains\Admin\University\Domain\Faculty\ValueObjects\Uuid;
use Project\Domains\Admin\University\Domain\University\University;
use Project\Domains\Admin\University\Domain\University\UniversityTranslate;
use Project\Domains\Admin\University\Infrastructure\Repositories\Doctrine\Faculty\Types\DescriptionType;
use Project\Domains\Admin\University\Infrastructure\Repositories\Doctrine\Faculty\Types\UuidType;
use Project\Domains\Admin\University\Infrastructure\Services\Media\Logo\Contracts\LogoableInterface;
use Project\Domains\Admin\University\Infrastructure\Services\Media\Logo\Contracts\LogoInterface;
use Project\Shared\Contracts\ArrayableInterface;
use Project\Shared\Domain\Aggregate\AggregateRoot;
use Project\Shared\Domain\Contracts\EntityUuid;
use Project\Shared\Domain\Traits\ActivableTrait;
use Project\Shared\Domain\Traits\CreatedAtAndUpdatedAtTrait;
use Project\Shared\Domain\Translation\AbstractTranslation;
use Project\Shared\Domain\Translation\DomainEvents\TranslationDomainEventTypeEnum;
use Project\Shared\Domain\Translation\TranslatableInterface;
use Project\Shared\Domain\Translation\TranslatableTrait;

#[ORM\Entity]
#[ORM\Table(name: 'faculty_faculties')]
#[ORM\HasLifecycleCallbacks]
class Faculty extends AggregateRoot implements EntityUuid, TranslatableInterface, LogoableInterface, ArrayableInterface
{
    use ActivableTrait,
        CreatedAtAndUpdatedAtTrait,
        TranslatableTrait;

    #[ORM\Id]
    #[ORM\Column(type: UuidType::NAME)]
    private Uuid $uuid;

    #[ORM\OneToOne(targetEntity: Logo::class, inversedBy: 'faculty', cascade: ['persist', 'remove'], orphanRemoval: true)]
    #[ORM\JoinColumn(name: 'logo_uuid', referencedColumnName: 'uuid', unique: true, nullable: false)]
    private ?Logo $logo;

    #[ORM\Column(name: 'name_uuid', nullable: true)]
    private string $nameUuid;

    #[ORM\ManyToOne(targetEntity: FacultyName::class, inversedBy: 'faculties')]
    #[ORM\JoinColumn(name: 'name_uuid', referencedColumnName: 'uuid', onDelete: 'SET NULL')]
    private FacultyName $name;

    #[ORM\Column(type: DescriptionType::NAME, nullable: true)]
    private Description $description;

    #[ORM\OneToMany(targetEntity: FacultyTranslation::class, mappedBy: 'object', cascade: ['persist', 'remove'], fetch: 'EAGER')]
    private Collection $translations;

    #[ORM\Column(name: 'university_uuid', nullable: true)]
    private ?string $universityUuid;

    #[ORM\ManyToOne(targetEntity: University::class, inversedBy: 'faculties')]
    #[ORM\JoinColumn(name: 'university_uuid', referencedColumnName: 'uuid', onDelete: 'SET NULL')]
    private University $university;

    #[ORM\OneToMany(targetEntity: Department::class,  mappedBy: 'faculty')]
    private Collection $departments;

    private function __construct(Uuid $uuid, FacultyName $name, University $university, bool $isActive)
    {
        $this->uuid = $uuid;
        $this->name = $name;
        $this->university = $university;
        $this->description = Description::fromValue(null);
        $this->logo = null;
        $this->isActive = $isActive;
        $this->departments = new ArrayCollection();
        $this->translations = new ArrayCollection();
    }

    public static function create(Uuid $uuid, FacultyName $name, University $university, bool $isActive): self
    {
        return new self($uuid, $name, $university, $isActive);
    }

    public function getUuid(): Uuid
    {
        return $this->uuid;
    }

    public function setName(FacultyName $name): self
    {
        $this->name = $name;

        return $this;
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

    public function getUniversity(): University
    {
        return $this->university;
    }

    public function changeUniversity(University $university): void
    {
        $this->university = $university;
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

    public function changeIsActive(bool $value): void
    {
        if ($this->isActive !== $value) {
            $this->isActive = $value;
        }
    }

    #[\Override]
    public function deleteLogo(): static
    {
        // if ($this->logo !== null) {
        //     $this->logo = null;
        // }

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
        return FacultyTranslation::class;
    }

    public function delete(): void
    {
        $this->record(new FacultyWasDeletedDomainEvent($this->uuid->value));
    }

    public function toArray(): array
    {
        return [
            'uuid' => $this->uuid->value,
            'name_uuid' => FacultyNameTranslate::execute($this->name)?->getUuid()->value,
            'name' => FacultyNameTranslate::execute($this->name)?->toArray(),
            'university_uuid' => $this->universityUuid,
            'university' => UniversityTranslate::execute($this->university)?->toArray(),
            'description' => $this->description->value,
            'logo' => $this->logo?->toArray(),
            'is_active' => $this->isActive,
            'created_at' => $this->createdAt->getTimestamp(),
            'updated_at' => $this->updatedAt->getTimestamp(),
        ];
    }
}
