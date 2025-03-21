<?php

declare(strict_types=1);

namespace Project\Domains\Admin\University\Domain\Application;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Project\Domains\Admin\Country\Domain\Country\Country;
use Project\Domains\Admin\Country\Domain\Country\CountryTranslate;
use Project\Domains\Admin\Language\Domain\Language\Language;
use Project\Domains\Admin\Language\Domain\Language\LanguageTranslate;
use Project\Domains\Admin\Student\Domain\Student\Student;
use Project\Domains\Admin\University\Domain\Alias\Alias;
use Project\Domains\Admin\University\Domain\Alias\AliasTranslate;
use Project\Domains\Admin\University\Domain\Application\Events\ApplicationStatusWasChangedDomainEvent;
use Project\Domains\Admin\University\Domain\Application\Events\ApplicationWasCreatedDomainEvent;
use Project\Domains\Admin\University\Domain\Application\ValueObjects\Status;
use Project\Domains\Admin\University\Domain\Application\ValueObjects\Uuid;
use Project\Domains\Admin\University\Domain\Degree\Degree;
use Project\Domains\Admin\University\Domain\Degree\DegreeTranslate;
use Project\Domains\Admin\University\Domain\Department\Department;
use Project\Domains\Admin\University\Domain\Department\DepartmentTranslate;
use Project\Domains\Admin\University\Domain\University\University;
use Project\Domains\Admin\University\Domain\University\UniversityTranslate;
use Project\Domains\Admin\University\Infrastructure\Application\Repositories\Doctrine\Types\UuidType;
use Project\Shared\Contracts\ArrayableInterface;
use Project\Shared\Domain\Aggregate\AggregateRoot;
use Project\Shared\Domain\Contracts\EntityUuid;
use Project\Shared\Domain\Traits\CreatedAtAndUpdatedAtTrait;

#[ORM\Entity]
#[ORM\Table(name: 'university_applications')]
#[ORM\HasLifecycleCallbacks]
class Application extends AggregateRoot implements
    EntityUuid,
    ArrayableInterface
{

    use CreatedAtAndUpdatedAtTrait;

    #[ORM\Id]
    #[ORM\Column(type: UuidType::NAME)]
    private Uuid $uuid;

    #[ORM\Column(name: 'student_uuid', nullable: true)]
    private ?string $studentUuid;

    #[ORM\ManyToOne(targetEntity: Student::class, inversedBy: 'applications')]
    #[ORM\JoinColumn(name: 'student_uuid', referencedColumnName: 'uuid', onDelete: 'SET NULL')]
    private Student $student;

    #[ORM\Column(name: 'alias_uuid', nullable: true)]
    private ?string $aliasUuid;

    #[ORM\ManyToOne(targetEntity: Alias::class, inversedBy: 'applications')]
    #[ORM\JoinColumn(name: 'alias_uuid', referencedColumnName: 'uuid', onDelete: 'SET NULL')]
    private ?Alias $alias;

    #[ORM\Column(name: 'language_uuid', nullable: true)]
    private ?string $languageUuid;

    #[ORM\ManyToOne(targetEntity: Language::class, inversedBy: 'applications')]
    #[ORM\JoinColumn(name: 'language_uuid', referencedColumnName: 'uuid', onDelete: 'SET NULL')]
    private Language $language;

    #[ORM\Column(name: 'degree_uuid', nullable: true)]
    private ?string $degreeUuid;

    #[ORM\ManyToOne(targetEntity: Degree::class, inversedBy: 'applications')]
    #[ORM\JoinColumn(name: 'degree_uuid', referencedColumnName: 'uuid', onDelete: 'SET NULL')]
    private Degree $degree;

    #[ORM\Column(name: 'country_uuid', nullable: true)]
    private ?string $countryUuid;

    #[ORM\ManyToOne(targetEntity: Country::class, inversedBy: 'applications')]
    #[ORM\JoinColumn(name: 'country_uuid', referencedColumnName: 'uuid', onDelete: 'SET NULL')]
    private ?Country $country;

    #[ORM\Column(name: 'university_uuid', nullable: true)]
    private ?string $universityUuid;

    #[ORM\ManyToOne(targetEntity: University::class, inversedBy: 'applications')]
    #[ORM\JoinColumn(name: 'university_uuid', referencedColumnName: 'uuid', onDelete: 'SET NULL')]
    private University $university;

    // #[ORM\ManyToOne(targetEntity: Faculty::class, inversedBy: 'applications')]
    // #[ORM\JoinColumn(name: 'faculty_uuid', referencedColumnName: 'uuid', nullable: false)]
    // private Faculty $faculty;

    #[ORM\ManyToMany(targetEntity: Department::class, inversedBy: 'applications')]
    #[ORM\JoinTable(
        name: 'university_applications_departments',
        joinColumns: new ORM\JoinColumn(name: 'application_uuid', referencedColumnName: 'uuid', nullable: false),
        inverseJoinColumns: new ORM\JoinColumn(name: 'department_uuid', referencedColumnName: 'uuid', nullable: false)
    )]
    private Collection $departments;

    #[ORM\OneToMany(targetEntity: Status::class, mappedBy: 'application', cascade: ['persist', 'remove'])]
    private Collection $statuses;

    #[ORM\Column(name: 'creator_role', nullable: false)]
    private string $creatorRole;

    #[ORM\Column(name: 'is_agreed_to_share_data', type: Types::BOOLEAN)]
    private bool $isAgreedToShareData;

    private function __construct(
        Uuid $uuid,
        Student $student,
        Language $language,
        Degree $degree,
        University $university,
        bool $isAgreedToShareData,
        string $creatorRole
    ) {
        $this->uuid = $uuid;
        $this->student = $student;
        $this->language = $language;
        $this->degree = $degree;
        $this->university = $university;
        $this->isAgreedToShareData = $isAgreedToShareData;
        $this->creatorRole = $creatorRole;
        $this->alias = null;
        $this->country = null;

        $this->departments = new ArrayCollection();
        $this->statuses = new StatusCollection();
    }

    public static function create(
        Uuid $uuid,
        Student $student,
        Language $language,
        Degree $degree,
        University $university,
        Status $status,
        bool $isAgreedToShareData,
        string $creatorRole
    ): self
    {
        $application = new self($uuid, $student, $language, $degree, $university, $isAgreedToShareData, $creatorRole);
        $application->record(new ApplicationWasCreatedDomainEvent($application->getUuid()->value));
        $application->addStatues($status);

        return $application;
    }

    public function getUuid(): Uuid
    {
        return $this->uuid;
    }

    public function setAlias(?Alias $alias): void
    {
        $this->alias = $alias;
    }

    public function changeAlias(Alias $alias): void
    {
        if ($this->alias->isNotEqual($alias)) {
            $this->alias = $alias;
        }
    }

    public function changeLanguage(Language $language): void
    {
        if ($this->language->isNotEqual($language)) {
            $this->language = $language;
        }
    }

    public function getDegree(): Degree
    {
        return $this->degree;
    }

    public function changeDegree(Degree $degree): void
    {
        if ($this->degree->isNotEqual($degree)) {
            $this->degree = $degree;
        }
    }

    public function getCountry(): Country
    {
        return $this->country;
    }

    public function setCountry(?Country $country): self
    {
        $this->country = $country;

        return $this;
    }

    public function changeCountry(Country $country): self
    {
        if ($this->country->isNotEquals($country)) {
            $this->country = $country;
        }

        return $this;
    }

    public function changeStudent(Student $student): self
    {
        if ($this->student->isNotEqual($student)) {
            $this->student = $student;
        }

        return $this;
    }

    public function getUniversity(): University
    {
        return $this->university;
    }

    public function changeUniversity(University $university): self
    {
        if ($this->university->isNotEquals($university)) {
            $this->university = $university;
        }

        return $this;
    }

    public function getDepartments(): Collection
    {
        return $this->departments;
    }

    public function getLanguage(): Language
    {
        return $this->language;
    }

    public function addDepartment(Department $department): void
    {
        if (! $this->departments->contains($department)) {
            $this->departments->add($department);
        }
    }

    public function removeDepartment(Department $department): void
    {
        if ($this->departments->contains($department)) {
            $this->departments->removeElement($department);
        }
    }

    public function addStatues(Status $status): void
    {
        $this->statuses->add($status);
        $status->setApplication($this);;
        $this->record(
            new ApplicationStatusWasChangedDomainEvent(
                $this->uuid->value,
                $status->getStatusValue()->getUuid()->value
            )
        );
    }

    public function getStatuses(): ArrayCollection
    {
        return $this->statuses;
    }

    public function getStatus(): Status
    {
        return $this->statuses->last();
    }

    public function getStudent(): Student
    {
        return $this->student;
    }

    public function isNull(): bool
    {
        return $this->uuid->value === null;
    }

    public function isNotNull(): bool
    {
        return $this->uuid->value !== null;
    }

    #[\Override]
    public function toArray(): array
    {
        return [
            'uuid' => $this->uuid->value,
            'student_uuid' => $this->studentUuid,
            'student' => $this->student->toArray(),
            'alias_uuid' => $this->aliasUuid,
            'alias' => AliasTranslate::execute($this->alias)?->toArray(),
            'language_uuid' => $this->languageUuid,
            'language' => LanguageTranslate::execute($this->language)?->toArray(),
            'degree_uuid' => $this->degreeUuid,
            'degree' => DegreeTranslate::execute($this->degree)?->toArray(),
            'country_uuid' => $this->countryUuid,
            'country' => CountryTranslate::execute($this->country)?->toArray(),
            'university_uuid' => $this->university->getUuid()->value,
            'university' => UniversityTranslate::execute($this->university)?->toArray(),
            'departments' => array_map(static fn (ArrayableInterface $item): array => DepartmentTranslate::execute($item)->toArray(), $this->departments->toArray()),
            'status_value_uuid' => $this->getStatus()?->getStatusValue()?->getUuid()?->value,
            'status' => StatusTranslate::execute($this->getStatus())?->toArrayWithTranslations(),
            'created_at' => $this->createdAt->getTimestamp(),
            'updated_at' => $this->updatedAt->getTimestamp(),
        ];
    }
}
