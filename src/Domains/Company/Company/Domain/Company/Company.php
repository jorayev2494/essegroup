<?php

namespace Project\Domains\Company\Company\Domain\Company;

use DateTimeImmutable;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Event\PrePersistEventArgs;
use Doctrine\ORM\Event\PreUpdateEventArgs;
use Doctrine\ORM\Mapping as ORM;
use Project\Domains\Company\Company\Domain\Company\Services\Logo\Contracts\LogoableInterface;
use Project\Domains\Company\Company\Domain\Company\Services\Logo\Contracts\LogoInterface;
use Project\Domains\Company\Company\Domain\Company\ValueObjects\Domain;
use Project\Domains\Company\Company\Domain\Company\ValueObjects\Email;
use Project\Domains\Company\Company\Domain\Company\ValueObjects\Logo;
use Project\Domains\Company\Company\Domain\Company\ValueObjects\Name;
use Project\Domains\Company\Company\Domain\Company\ValueObjects\Uuid;
use Project\Domains\Company\Company\Domain\Status\Status;
use Project\Domains\Company\Company\Infrastructure\Repositories\Doctrine\Company\Types\DomainType;
use Project\Domains\Company\Company\Infrastructure\Repositories\Doctrine\Company\Types\NameType;
use Project\Domains\Company\Company\Infrastructure\Repositories\Doctrine\Company\Types\EmailType;
use Project\Domains\Company\Company\Infrastructure\Repositories\Doctrine\Company\Types\UuidType;
use Project\Shared\Contracts\ArrayableInterface;
use Project\Shared\Domain\Aggregate\AggregateRoot;

#[ORM\Entity]
#[ORM\Table('company_companies')]
#[ORM\HasLifecycleCallbacks]
class Company extends AggregateRoot implements LogoableInterface
{
    #[ORM\Id]
    #[ORM\Column(type: UuidType::NAME)]
    private Uuid $uuid;

    #[ORM\OneToOne(targetEntity: Logo::class, inversedBy: 'company', cascade: ['persist', 'remove'], orphanRemoval: true)]
    #[ORM\JoinColumn(name: 'logo_uuid', referencedColumnName: 'uuid')]
    private ?Logo $logo = null;

    #[ORM\Column(type: NameType::NAME)]
    private Name $name;

    #[ORM\Column(type: EmailType::NAME)]
    private Email $email;

    #[ORM\Column(type: DomainType::NAME)]
    private Domain $domain;

    // #[ORM\OneToOne(targetEntity: Status::class, mappedBy: 'company')]
    // private Status $status;

    #[ORM\OneToMany(targetEntity: Status::class, mappedBy: 'company', cascade: ['persist', 'remove'])]
    private Collection $statuses;

    // #[ORM\OneToMany(targetEntity: University::class, mappedBy: 'company', cascade: ['persist', 'remove'])]
    // private Collection $universities;

    #[ORM\Column(name: 'created_at', type: Types::DATETIME_IMMUTABLE)]
    private DateTimeImmutable $createdAt;

    #[ORM\Column(name: 'updated_at', type: Types::DATETIME_IMMUTABLE)]
    private DateTimeImmutable $updatedAt;

    private function __construct(Uuid $uuid, Name $name, Email $email, Domain $domain, Status $status)
    {
        $this->uuid = $uuid;
        $this->name = $name;
        $this->email = $email;
        $this->domain = $domain;
        $this->statuses = new ArrayCollection();
        // $this->universities = new ArrayCollection();
        $this->addStatus($status);
    }

    public static function fromPrimitives(string $uuid, string $name, string $email, string $domain, string $status, ?string $note = null): self
    {
        return new self(
            Uuid::fromValue($uuid),
            Name::fromValue($name),
            Email::fromValue($email),
            Domain::fromValue($domain),
            Status::fromPrimitives($status, $note)
        );
    }

    public function getUuid(): Uuid
    {
        return $this->uuid;
    }

    public function getName(): Name
    {
        return $this->name;
    }

    public function getDomain(): Domain
    {
        return $this->domain;
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
        }

        return $this;
    }

    public function changeDomain(Domain $domain): self
    {
        if ($this->domain->isNotEquals($domain)) {
            $this->domain = $domain;
        }

        return $this;
    }

    public function addStatus(Status $status): self
    {
        $status->setCompany($this);
        $this->statuses->add($status);

        return $this;
    }

    // public function addUniversity(University $university): self
    // {
    //     $this->universities->add($university);
    //     $university->setCompany($this);
    //
    //     return $this;
    // }

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

    public function delete(): void
    {
        $this->record(new CompanyWasDeletedDomainEvent($this->uuid));
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
            'logo' => $this->logo?->toArray(),
            'name' => $this->name->value,
            'email' => $this->email->value,
            'domain' => $this->domain->value,
            'status' => $this->getStatus()->toArray(),
            'statuses' => array_map(static fn (ArrayableInterface $status): array => $status->toArray(), $this->statuses->toArray()),
            'created_at' => $this->createdAt->getTimestamp(),
            'updated_at' => $this->updatedAt->getTimestamp(),
        ];
    }
}