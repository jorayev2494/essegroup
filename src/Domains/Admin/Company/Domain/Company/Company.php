<?php

declare(strict_types=1);

namespace Project\Domains\Admin\Company\Domain\Company;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Project\Domains\Admin\Company\Domain\Company\Events\CompanyDomainWasChangedDomainEvent;
use Project\Domains\Admin\Company\Domain\Company\Events\CompanyEmailWasChangedDomainEvent;
use Project\Domains\Admin\Company\Domain\Company\Events\CompanyNameWasChangedDomainEvent;
use Project\Domains\Admin\Company\Domain\Company\Events\CompanyWasCreatedDomainEvent;
use Project\Domains\Admin\Company\Domain\Company\Events\CompanyWasDeletedDomainEvent;
use Project\Domains\Admin\Company\Domain\Company\Services\Logo\Contracts\LogoableInterface;
use Project\Domains\Admin\Company\Domain\Company\Services\Logo\Contracts\LogoInterface;
use Project\Domains\Admin\Company\Domain\Company\ValueObjects\Email;
use Project\Domains\Admin\Company\Domain\Company\ValueObjects\Logo;
use Project\Domains\Admin\Company\Domain\Company\ValueObjects\Name;
use Project\Domains\Admin\Company\Domain\Company\ValueObjects\Uuid;
use Project\Domains\Admin\Company\Domain\Employee\Employee;
use Project\Domains\Admin\Company\Domain\Status\Status;
use Project\Domains\Admin\Company\Infrastructure\Repositories\Doctrine\Company\Types\EmailType;
use Project\Domains\Admin\Company\Infrastructure\Repositories\Doctrine\Company\Types\NameType;
use Project\Domains\Admin\Company\Infrastructure\Repositories\Doctrine\Company\Types\UuidType;
use Project\Domains\Admin\Student\Domain\Student\Student;
use Project\Domains\Admin\University\Domain\Application\Application;
use Project\Domains\Admin\University\Domain\Department\Department;
use Project\Domains\Admin\University\Domain\Faculty\Faculty;
use Project\Domains\Admin\University\Domain\University\University;
use Project\Shared\Contracts\ArrayableInterface;
use Project\Shared\Domain\Aggregate\AggregateRoot;
use Project\Shared\Domain\Contracts\EntityUuid;
use Project\Shared\Domain\Traits\CreatedAtAndUpdatedAtTrait;

#[ORM\Entity]
#[ORM\Table(name: 'company_companies')]
#[ORM\HasLifecycleCallbacks]
class Company extends AggregateRoot implements EntityUuid, LogoableInterface, ArrayableInterface
{
    use CreatedAtAndUpdatedAtTrait;

    #[ORM\Id]
    #[ORM\Column(type: UuidType::NAME)]
    private Uuid $uuid;

    #[ORM\OneToOne(targetEntity: Logo::class, inversedBy: 'company', cascade: ['persist', 'remove'], orphanRemoval: true)]
    #[ORM\JoinColumn(name: 'logo_uuid', referencedColumnName: 'uuid')]
    private ?Logo $logo = null;

    #[ORM\Column(type: EmailType::NAME)]
    private Email $email;

    #[ORM\Column(type: NameType::NAME)]
    private Name $name;

    #[ORM\Column(name: 'is_main', type: Types::BOOLEAN, options: ['default' => false])]
    private bool $isMain;

    // #[ORM\OneToOne(targetEntity: Status::class, mappedBy: 'company')]
    // private Status $status;

    #[ORM\OneToMany(targetEntity: Status::class, mappedBy: 'company', cascade: ['persist', 'remove'])]
    private Collection $statuses;

    #[ORM\OneToMany(targetEntity: University::class, mappedBy: 'company', cascade: ['persist'])]
    private Collection $universities;

    #[ORM\OneToMany(targetEntity: Faculty::class, mappedBy: 'company', cascade: ['persist'])]
    private Collection $faculties;

    #[ORM\OneToMany(targetEntity: Department::class, mappedBy: 'company', cascade: ['persist'])]
    private Collection $departments;

    #[ORM\OneToMany(targetEntity: Student::class, mappedBy: 'company', cascade: ['persist'])]
    private Collection $students;

    #[ORM\OneToMany(targetEntity: Application::class, mappedBy: 'company', cascade: ['persist'])]
    private Collection $applications;

    #[ORM\OneToMany(targetEntity: Employee::class, mappedBy: 'company', cascade: ['persist'])]
    private Collection $employees;

    private function __construct(Uuid $uuid, Name $name, Email $email, bool $isMain)
    {
        $this->uuid = $uuid;
        $this->name = $name;
        $this->email = $email;
        $this->isMain = $isMain;
        $this->statuses = new ArrayCollection();
        $this->universities = new ArrayCollection();
        $this->faculties = new ArrayCollection();
        $this->departments = new ArrayCollection();
        $this->applications = new ArrayCollection();
        $this->employees = new ArrayCollection();
    }

    public static function create(Uuid $uuid, Name $name, Email $email, Status $status, bool $isMain): self
    {
        $company = new self($uuid, $name, $email, $isMain);
        $company->addStatus($status);
//        $company->record(
//            new CompanyWasCreatedDomainEvent(
//                $company->getUuid()->value,
//                $company->getName()->value,
//                $company->getEmail()->value,
//                $company->getStatus()->getValue()->value,
//            )
//        );

        return $company;
    }

    public function getUuid(): Uuid
    {
        return $this->uuid;
    }

    public function getName(): Name
    {
        return $this->name;
    }

    public function getEmail(): Email
    {
        return $this->email;
    }

    public function getLogo(): ?Logo
    {
        return $this->logo;
    }

    public function getStatus(): Status
    {
        return $this->statuses->last();
    }

    public function changeName(Name $name): self
    {
        if ($this->name->isNotEquals($name)) {
            $this->name = $name;
            $this->record(new CompanyNameWasChangedDomainEvent($this->uuid->value, $this->name->value));
        }

        return $this;
    }

    public function changeEmail(Email $email): self
    {
        if ($this->email->isNotEquals($email)) {
            $this->email = $email;
            $this->record(new CompanyEmailWasChangedDomainEvent($this->uuid->value, $this->email->value));
        }

        return $this;
    }

    public function changeIsMain(bool $isMain): self
    {
        if ($this->isMain !== $isMain) {
            $this->isMain = $isMain;
        }

        return $this;
    }

    public function addStatus(Status $status): self
    {
        $status->setCompany($this);
        $this->statuses->add($status);

        return $this;
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
        // $this->logo = null;

        return $this;
    }

    public function getUniversities(): Collection
    {
        return $this->universities;
    }

    public function addUniversity(University $university): self
    {
        $this->universities->add($university);
        $university->setCompany($this);

        return $this;
    }

    public function removeUniversity(University $university): void
    {
        if ($this->universities->contains($university)) {
            $this->universities->removeElement($university);
        }
    }

    /**
     * @return Collection<int, Faculty>
     */
    public function getFaculties(): Collection
    {
        return $this->faculties;
    }

    /**
     * @return Collection<int, Department>
     */
    public function getDepartments(): Collection
    {
        return $this->departments;
    }

    /**
     * @return Collection<int, Application>
     */
    public function getApplications(): Collection
    {
        return $this->applications;
    }

    public function addEmployee(Employee $employee): self
    {
        if (! $this->employees->contains($employee)) {
            $this->employees->add($employee);
            $employee->setCompany($this);
        }

        return $this;
    }

    public function delete(): void
    {
        // $this->record(new CompanyWasDeletedDomainEvent($this->uuid->value));
    }

    public function isEqual(self $other): bool
    {
        return $this->uuid->value === $other->getUuid()->value;
    }

    public function isNotEqual(self $other): bool
    {
        return $this->uuid->value !== $other->getUuid()->value;
    }

    public function isNull(): bool
    {
        return $this->uuid->isNull();
    }

    public function isNotNull(): bool
    {
        return $this->uuid->isNotNull();
    }

    public function toArray(): array
    {
        return [
            'uuid' => $this->uuid->value,
            'logo' => $this->logo?->toArray(),
            'name' => $this->name->value,
            'email' => $this->email->value,
            'is_main' => $this->isMain,
            'status' => $this->getStatus()->toArray(),
            'statuses' => array_map(static fn (ArrayableInterface $status): array => $status->toArray(), $this->statuses->toArray()),
            'created_at' => $this->createdAt->getTimestamp(),
            'updated_at' => $this->updatedAt->getTimestamp(),
        ];
    }
}
