<?php

namespace Project\Domains\Admin\University\Domain\Company;

use DateTimeImmutable;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Event\PrePersistEventArgs;
use Doctrine\ORM\Event\PreUpdateEventArgs;
use Doctrine\ORM\Mapping as ORM;
use Project\Domains\Admin\University\Domain\Application\Application;
use Project\Domains\Admin\University\Domain\Company\ValueObjects\Domain;
use Project\Domains\Admin\University\Domain\Company\ValueObjects\Name;
use Project\Domains\Admin\University\Domain\Company\ValueObjects\Uuid;
use Project\Domains\Admin\University\Domain\Department\Department;
use Project\Domains\Admin\University\Domain\Faculty\Faculty;
use Project\Domains\Admin\University\Infrastructure\Repositories\Doctrine\Company\Types\DomainType;
use Project\Domains\Admin\University\Infrastructure\Repositories\Doctrine\Company\Types\NameType;
use Project\Domains\Admin\University\Infrastructure\Repositories\Doctrine\Company\Types\StatusType;
use Project\Domains\Admin\University\Infrastructure\Repositories\Doctrine\Company\Types\UuidType;
use Project\Domains\Admin\University\Domain\Company\ValueObjects\Status;
use Project\Domains\Admin\University\Domain\University\University;
use Project\Shared\Domain\Aggregate\AggregateRoot;

#[ORM\Entity]
#[ORM\Table('university_companies')]
#[ORM\HasLifecycleCallbacks]
class Company extends AggregateRoot
{
    #[ORM\Id]
    #[ORM\Column(type: UuidType::NAME)]
    private Uuid $uuid;

    #[ORM\Column(type: NameType::NAME, unique: true)]
    private Name $name;

    #[ORM\Column(type: DomainType::NAME, unique: true)]
    private Domain $domain;

    #[ORM\Column(type: StatusType::NAME)]
    private Status $status;

    #[ORM\OneToMany(targetEntity: University::class, mappedBy: 'company', cascade: ['persist'])]
    private Collection $universities;

    #[ORM\OneToMany(targetEntity: Faculty::class, mappedBy: 'company', cascade: ['persist'])]
    private Collection $faculties;

    #[ORM\OneToMany(targetEntity: Department::class, mappedBy: 'company', cascade: ['persist'])]
    private Collection $departments;

    #[ORM\OneToMany(targetEntity: Application::class, mappedBy: 'company', cascade: ['persist'])]
    private Collection $applications;

    #[ORM\Column(name: 'created_at', type: Types::DATETIME_IMMUTABLE)]
    private DateTimeImmutable $createdAt;

    #[ORM\Column(name: 'updated_at', type: Types::DATETIME_IMMUTABLE)]
    private DateTimeImmutable $updatedAt;

    private function __construct(Uuid $uuid, Name $name, Domain $domain, Status $status)
    {
        $this->uuid = $uuid;
        $this->name = $name;
        $this->domain = $domain;
        $this->status = $status;
        $this->universities = new ArrayCollection();
        $this->faculties = new ArrayCollection();
        $this->departments = new ArrayCollection();
        $this->applications = new ArrayCollection();
    }

    public static function fromPrimitives(string $uuid, string $name, string $domain, string $status): self
    {
        return new self(
            Uuid::fromValue($uuid),
            Name::fromValue($name),
            Domain::fromValue($domain),
            Status::fromValue($status)
        );
    }

    public function getUuid(): Uuid
    {
        return $this->uuid;
    }

    public function setName(Name $name): self
    {
        if ($this->name->isNotEquals($name)) {
            $this->name = $name;
        }

        return $this;
    }

    public function setDomain(Domain $domain): self
    {
        if ($this->domain->isNotEquals($domain)) {
            $this->domain = $domain;
        }

        return $this;
    }

    public function setStatus(Status $status): self
    {
        $this->status = $status;

        return $this;
    }

    /**
     * @return Collection<int, University>
     */
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

    #[ORM\PrePersist]
    public function prePersisting(PrePersistEventArgs $event): void
    {
        $this->createdAt = new DateTimeImmutable();
        $this->updatedAt = new DateTimeImmutable();
    }

    #[ORM\PreUpdate]
    public function preUpdating(PreUpdateEventArgs $event): void
    {
        $this->updatedAt = new DateTimeImmutable();
    }

    public function toArray(): array
    {
        return [
            'uuid' => $this->uuid->value,
            'name' => $this->name->value,
            'domain' => $this->domain->value,
            'status' => $this->status->value,
            'created_at' => $this->createdAt->getTimestamp(),
            'updated_at' => $this->updatedAt->getTimestamp(),
        ];
    }
}
