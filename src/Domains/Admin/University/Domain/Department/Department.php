<?php

declare(strict_types=1);

namespace Project\Domains\Admin\University\Domain\Department;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Event\PrePersistEventArgs;
use Doctrine\ORM\Event\PreUpdateEventArgs;
use Doctrine\ORM\Mapping as ORM;
use Project\Domains\Admin\University\Domain\Application\Application;
use Project\Domains\Admin\Company\Domain\Company\Company;
use Project\Domains\Admin\University\Domain\Degree\Degree;
use Project\Domains\Admin\University\Domain\Degree\DegreeCollection;
use Project\Domains\Admin\University\Domain\Department\Events\ApplicationWasDeletedFromDepartmentDomainEvent;
use Project\Domains\Admin\University\Domain\Department\Events\DepartmentWasDeletedDomainEvent;
use Project\Domains\Admin\University\Domain\Department\ValueObjects\Description;
use Project\Domains\Admin\University\Domain\Department\ValueObjects\Name;
use Project\Domains\Admin\University\Domain\Department\ValueObjects\Uuid;
use Project\Domains\Admin\University\Domain\Faculty\Faculty;
use Project\Domains\Admin\University\Domain\Faculty\FacultyTranslate;
use Project\Domains\Admin\University\Domain\University\University;
use Project\Domains\Admin\University\Domain\University\UniversityTranslate;
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

    #[ORM\Column(name: 'company_uuid', nullable: true)]
    private ?string $companyUuid;

    #[ORM\ManyToOne(targetEntity: Company::class, inversedBy: 'departments')]
    #[ORM\JoinColumn(name: 'company_uuid', referencedColumnName: 'uuid', onDelete: 'SET NULL')]
    private Company $company;

    #[ORM\Column(name: 'university_uuid', type: Types::STRING, nullable: true)]
    private ?string $universityUuid;

    #[ORM\ManyToOne(targetEntity: University::class, inversedBy: 'departments')]
    #[ORM\JoinColumn(name: 'university_uuid', referencedColumnName: 'uuid', onDelete: 'SET NULL')]
    private University $university;

    #[ORM\ManyToMany(targetEntity: Application::class, mappedBy: 'departments')]
    private Collection $applications;

    #[ORM\ManyToMany(targetEntity: Degree::class, inversedBy: 'departments')]
    #[ORM\JoinTable(
        name: 'university_departments_degrees',
        joinColumns: new ORM\JoinColumn(name: 'department_uuid', referencedColumnName: 'uuid'),
        inverseJoinColumns: new ORM\JoinColumn(name: 'degree_uuid', referencedColumnName: 'uuid')
    )]
    private Collection $degrees;

    #[ORM\Column(name: 'faculty_uuid', type: Types::STRING, nullable: true)]
    private ?string $facultyUuid;

    #[ORM\ManyToOne(targetEntity: Faculty::class, inversedBy: 'departments')]
    #[ORM\JoinColumn(name: 'faculty_uuid', referencedColumnName: 'uuid', onDelete: 'SET NULL')]
    private Faculty $faculty;

    #[ORM\Column(name: 'is_filled', type: Types::BOOLEAN)]
    private bool $isFilled;

    private function __construct(
        Uuid $uuid,
        Company $company,
        University $university,
        ArrayCollection $degrees,
        bool $isActive
    )
    {
        $this->uuid = $uuid;
        $this->university = $university;
        $this->company = $company;
        $this->degrees = $degrees;
        $this->name = Name::fromValue(null);
        $this->description = Description::fromValue(null);
        $this->translations = new ArrayCollection();
        $this->applications = new ArrayCollection();
        $this->isActive = $isActive;
        $this->isFilled = false;
    }

    public static function fromPrimitives(string $uuid, Company $company, University $university, ArrayCollection $degrees, bool $isActive): self
    {
        return new self(Uuid::fromValue($uuid), $company, $university, $degrees, $isActive);
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

    public function changeCompany(Company $company): void
    {
        $this->company = $company;
    }

    public function getUniversity(): University
    {
        return $this->university;
    }

    public function changeUniversity(University $university): void
    {
        $this->university = $university;
    }

    public function changeFaculty(Faculty $faculty): void
    {
        $this->faculty = $faculty;
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

    public function setCompany(?Company $company): void
    {
        $this->company = $company;
    }

    public function getFaculty(): Faculty
    {
        return $this->faculty;
    }

    public function setFaculty(Faculty $faculty): void
    {
        $this->faculty = $faculty;
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
            'company_uuid' => $this->companyUuid,
            'company' => $this->company->getUuid()->isNotNull() ? $this->company->toArray() : null,
            'university_uuid' => $this->universityUuid,
            'university' => UniversityTranslate::execute($this->university)?->toArray(),
            'faculty_uuid' => $this->facultyUuid,
            'faculty' => FacultyTranslate::execute($this->faculty)?->toArray(),
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
