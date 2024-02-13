<?php

declare(strict_types=1);

namespace Project\Domains\Admin\University\Domain\Department;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Event\PrePersistEventArgs;
use Doctrine\ORM\Event\PreUpdateEventArgs;
use Doctrine\ORM\Mapping as ORM;
use Project\Domains\Admin\University\Domain\Department\ValueObjects\Description;
use Project\Domains\Admin\University\Domain\Department\ValueObjects\Name;
use Project\Domains\Admin\University\Domain\Department\ValueObjects\Uuid;
use DateTimeImmutable;
use Project\Domains\Admin\University\Domain\Faculty\Faculty;
use Project\Domains\Admin\University\Infrastructure\Repositories\Doctrine\Department\Types\DescriptionType;
use Project\Domains\Admin\University\Infrastructure\Repositories\Doctrine\Department\Types\NameType;
use Project\Domains\Admin\University\Infrastructure\Repositories\Doctrine\Department\Types\UuidType;
use Project\Shared\Contracts\ArrayableInterface;
use Project\Shared\Domain\Translation\AbstractTranslation;
use Project\Shared\Domain\Translation\DomainEvents\TranslationDomainEventTypeEnum;
use Project\Shared\Domain\Translation\TranslatableInterface;
use Project\Shared\Domain\Translation\TranslatableTrait;

#[ORM\Entity]
#[ORM\Table(name: 'university_departments')]
#[ORM\HasLifecycleCallbacks]
class Department implements ArrayableInterface, TranslatableInterface
{
    use TranslatableTrait;

    #[ORM\Id]
    #[ORM\Column(type: UuidType::NAME)]
    private Uuid $uuid;

    #[ORM\Column(type: NameType::NAME, nullable: true)]
    private Name $name;

    #[ORM\Column(type: DescriptionType::NAME, nullable: true)]
    private Description $description;

    #[ORM\OneToMany(targetEntity: DepartmentTranslation::class, mappedBy: 'object', cascade: ['persist', 'remove'], fetch: 'EAGER')]
    private Collection $translations;

    #[ORM\Column(name: 'faculty_uuid', type: Types::STRING)]
    private string $facultyUuid;

    #[ORM\ManyToOne(targetEntity: Faculty::class, inversedBy: 'departments')]
    #[ORM\JoinColumn(name: 'faculty_uuid', referencedColumnName: 'uuid', nullable: false)]
    private Faculty $faculty;

    #[ORM\Column(name: 'is_active')]
    private bool $isActive;

    #[ORM\Column(name: 'created_at', type: Types::DATETIME_IMMUTABLE)]
    protected DateTimeImmutable $createdAt;

    #[ORM\Column(name: 'updated_at', type: Types::DATETIME_IMMUTABLE)]
    protected DateTimeImmutable $updatedAt;

    private function __construct(
        Uuid $uuid,
        bool $isActive
    )
    {
        $this->uuid = $uuid;
        $this->name = Name::fromValue(null);
        $this->description = Description::fromValue(null);
        $this->translations = new ArrayCollection();
        $this->isActive = $isActive;
    }

    public static function fromPrimitives(string $uuid, bool $isActive): self
    {
        return new self(Uuid::fromValue($uuid), $isActive);
    }

    public function getName(): Name
    {
        return $this->name;
    }

    public function setName(Name $name): void
    {
        $this->name = $name;
    }

    public function getDescription(): Description
    {
        return $this->description;
    }

    public function setDescription(Description $description): void
    {
        $this->description = $description;
    }

    public function getFaculty(): Faculty
    {
        return $this->faculty;
    }

    public function setFaculty(Faculty $faculty): void
    {
        $this->faculty = $faculty;
    }

    #[\Override]
    public function getTranslations(): Collection
    {
        return $this->translations;
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
            'faculty_uuid' => $this->facultyUuid,
            'name' => $this->name->value,
            'description' => $this->description->value,
            'is_active' => $this->isActive,
            'created_at' => $this->createdAt->getTimestamp(),
            'updated_at' => $this->updatedAt->getTimestamp(),
        ];
    }
}
