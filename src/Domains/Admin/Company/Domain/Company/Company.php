<?php

namespace Project\Domains\Admin\Company\Domain\Company;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Event\PrePersistEventArgs;
use Doctrine\ORM\Event\PreUpdateEventArgs;
use Project\Domains\Admin\Company\Domain\Company\ValueObjects\Domain;
use Project\Domains\Admin\Company\Domain\Company\ValueObjects\Name;
use Project\Domains\Admin\Company\Domain\Company\ValueObjects\Uuid;
use Project\Domains\Admin\Company\Domain\Status\Status;
use Project\Domains\Admin\Company\Infrastructure\Repositories\Doctrine\Company\Types\DomainType;
use Project\Domains\Admin\Company\Infrastructure\Repositories\Doctrine\Company\Types\NameType;
use Project\Domains\Admin\Company\Infrastructure\Repositories\Doctrine\Company\Types\UuidType;
use Project\Shared\Domain\Aggregate\AggregateRoot;

use Doctrine\ORM\Mapping as ORM;
use DateTimeImmutable;

#[ORM\Entity]
#[ORM\Table('company_companies')]
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

    #[ORM\OneToMany(targetEntity: Status::class, mappedBy: 'company', cascade: ['persist', 'remove'])]
    private Collection $statuses;

    #[ORM\Column(name: 'created_at', type: Types::DATETIME_IMMUTABLE)]
    private DateTimeImmutable $createdAt;

    #[ORM\Column(name: 'updated_at', type: Types::DATETIME_IMMUTABLE)]
    private DateTimeImmutable $updatedAt;

    private function __construct(Uuid $uuid, Name $name, Domain $domain)
    {
        $this->uuid = $uuid;
        $this->name = $name;
        $this->domain = $domain;
        $this->statuses = new ArrayCollection();
    }

    public static function create(Uuid $uuid, Name $name, Domain $domain): self
    {
        $domain = new self($uuid, $name, $domain);
        $domain->addStatus(Status::fromPrimitives('new'));

        return $domain;
    }

    public function getUuid(): Uuid
    {
        return $this->uuid;
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
            'created_at' => $this->createdAt->getTimestamp(),
            'updated_at' => $this->updatedAt->getTimestamp(),
        ];
    }
}
