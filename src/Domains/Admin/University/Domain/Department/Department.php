<?php

declare(strict_types=1);

namespace Project\Domains\Admin\University\Domain\Department;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Project\Domains\Admin\University\Domain\Application\Application;
use Project\Domains\Admin\University\Domain\Degree\Degree;
use Project\Domains\Admin\University\Domain\Degree\DegreeCollection;
use Project\Domains\Admin\University\Domain\Department\Events\ApplicationWasDeletedFromDepartmentDomainEvent;
use Project\Domains\Admin\University\Domain\Department\Events\DepartmentWasDeletedDomainEvent;
use Project\Domains\Admin\University\Domain\Department\ValueObjects\Description;
use Project\Domains\Admin\University\Domain\Department\ValueObjects\Name;
use Project\Domains\Admin\University\Domain\Department\ValueObjects\Uuid;
use Project\Domains\Admin\University\Infrastructure\Repositories\Doctrine\Department\Types\DescriptionType;
use Project\Domains\Admin\University\Infrastructure\Repositories\Doctrine\Department\Types\NameType;
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

    #[ORM\Column(type: NameType::NAME, nullable: true)]
    private Name $name;

    #[ORM\Column(type: DescriptionType::NAME, nullable: true)]
    private Description $description;

    #[ORM\OneToMany(targetEntity: DepartmentTranslation::class, mappedBy: 'object', cascade: ['persist', 'remove'], fetch: 'EAGER')]
    private Collection $translations;

    #[ORM\ManyToMany(targetEntity: Application::class, mappedBy: 'departments')]
    private Collection $applications;

    #[ORM\ManyToMany(targetEntity: Degree::class, inversedBy: 'departments')]
    #[ORM\JoinTable(
        name: 'university_departments_degrees',
        joinColumns: new ORM\JoinColumn(name: 'department_uuid', referencedColumnName: 'uuid'),
        inverseJoinColumns: new ORM\JoinColumn(name: 'degree_uuid', referencedColumnName: 'uuid')
    )]
    private Collection $degrees;

    #[ORM\Column(name: 'is_filled', type: Types::BOOLEAN)]
    private bool $isFilled;

    private function __construct(
        Uuid $uuid,
        ArrayCollection $degrees,
        bool $isActive
    )
    {
        $this->uuid = $uuid;
        $this->degrees = $degrees;
        $this->name = Name::fromValue(null);
        $this->description = Description::fromValue(null);
        $this->translations = new ArrayCollection();
        $this->applications = new ArrayCollection();
        $this->isActive = $isActive;
        $this->isFilled = false;
    }

    public static function fromPrimitives(string $uuid, ArrayCollection $degrees, bool $isActive): self
    {
        return new self(Uuid::fromValue($uuid), $degrees, $isActive);
    }

    public function delete(): void
    {
        $this->record(new DepartmentWasDeletedDomainEvent($this->uuid->value));
    }

    public function getUuid(): UUid
    {
        return $this->uuid;
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

    public function addDegree(Degree $degree): self
    {
        if (! $this->degrees->contains($degree)) {
            $this->degrees->add($degree);
        }

        return $this;
    }

    public function getDegrees(): Collection
    {
        return $this->degrees;
    }

    public function clearDegrees(): self
    {
        $this->degrees = new ArrayCollection();

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

    #[\Override]
    public function toArray(): array
    {
        return [
            'uuid' => $this->uuid->value,
            'name' => $this->name->value,
            'description' => $this->description->value,
            'degrees' => (new DegreeCollection($this->degrees->toArray()))->translateItems()->toArray(),
            'is_filled' => $this->isFilled,
            'is_active' => $this->isActive,
            'created_at' => $this->createdAt->getTimestamp(),
            'updated_at' => $this->updatedAt->getTimestamp(),
        ];
    }
}
