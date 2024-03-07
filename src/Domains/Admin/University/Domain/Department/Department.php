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
use Project\Domains\Admin\University\Domain\Company\Company;
use Project\Domains\Admin\University\Domain\Department\ValueObjects\Description;
use Project\Domains\Admin\University\Domain\Department\ValueObjects\Name;
use Project\Domains\Admin\University\Domain\Department\ValueObjects\Uuid;
use DateTimeImmutable;
use Project\Domains\Admin\University\Domain\Faculty\Faculty;
use Project\Domains\Admin\University\Domain\University\University;
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

    #[ORM\Column(name: 'university_uuid', type: Types::STRING)]
    private string $universityUuid;

    #[ORM\ManyToOne(targetEntity: University::class, inversedBy: 'departments')]
    #[ORM\JoinColumn(name: 'university_uuid', referencedColumnName: 'uuid', nullable: false)]
    private University $university;

    #[ORM\Column(name: 'company_uuid')]
    private string $companyUuid;

    #[ORM\ManyToOne(targetEntity: Company::class, inversedBy: 'departments')]
    #[ORM\JoinColumn(name: 'company_uuid', referencedColumnName: 'uuid', nullable: false)]
    private Company $company;

    #[ORM\OneToMany(targetEntity: Application::class, mappedBy: 'departments')]
    private Collection $applications;

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
        Company $company,
        University $university,
        bool $isActive
    )
    {
        $this->uuid = $uuid;
        $this->university = $university;
        $this->company = $company;
        $this->name = Name::fromValue(null);
        $this->description = Description::fromValue(null);
        $this->translations = new ArrayCollection();
        $this->applications = new ArrayCollection();
        $this->isActive = $isActive;
    }

    public static function fromPrimitives(string $uuid, Company $company, University $university, bool $isActive): self
    {
        return new self(Uuid::fromValue($uuid), $company, $university, $isActive);
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

    public function addApplication(Application $application): void
    {
        if (! $this->applications->contains($application)) {
            $this->applications->add($application);
        }
    }

    public function removeApplication(Application $application): void
    {
        if ($this->applications->contains($application)) {
            $this->applications->removeElement($application);
        }
    }

    public function setCompany(Company $company): void
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
            'company_uuid' => $this->companyUuid,
            'company' => $this->company->toArray(),
            'university_uuid' => $this->universityUuid,
            'university' => $this->university->toArray(),
            'faculty_uuid' => $this->facultyUuid,
            'faculty' => $this->faculty->toArray(),
            'name' => $this->name->value,
            'description' => $this->description->value,
            'is_active' => $this->isActive,
            'created_at' => $this->createdAt->getTimestamp(),
            'updated_at' => $this->updatedAt->getTimestamp(),
        ];
    }
}
