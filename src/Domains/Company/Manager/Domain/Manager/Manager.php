<?php

declare(strict_types=1);

namespace Project\Domains\Company\Manager\Domain\Manager;

use Project\Domains\Company\Manager\Domain\Manager\Events\ManagerWasCreatedDomainEvent;
use Project\Domains\Company\Manager\Domain\Manager\Events\ManagerWasDeletedDomainEvent;
use Project\Domains\Company\Manager\Domain\Manager\ValueObjects\CompanyUuid;
use Project\Domains\Company\Manager\Domain\Manager\ValueObjects\Email;
use Project\Domains\Company\Manager\Domain\Manager\ValueObjects\FirstName;
use Project\Domains\Company\Manager\Domain\Manager\ValueObjects\LastName;
use Project\Domains\Company\Manager\Domain\Manager\ValueObjects\Uuid;
use Project\Domains\Company\Manager\Infrastructure\Manager\Repositories\Doctrine\Types\CompanyUuidType;
use Project\Domains\Company\Manager\Infrastructure\Manager\Repositories\Doctrine\Types\EmailType;
use Project\Domains\Company\Manager\Infrastructure\Manager\Repositories\Doctrine\Types\FirstNameType;
use Project\Domains\Company\Manager\Infrastructure\Manager\Repositories\Doctrine\Types\LastNameType;
use Project\Domains\Company\Manager\Infrastructure\Manager\Repositories\Doctrine\Types\UuidType;
use Project\Shared\Domain\Aggregate\AggregateRoot;
use Doctrine\ORM\Mapping as ORM;
use Project\Shared\Domain\Traits\CreatedAtAndUpdatedAtTrait;

#[ORM\Entity]
#[ORM\Table(name: 'company_managers')]
#[ORM\HasLifecycleCallbacks]
class Manager extends AggregateRoot
{
    use CreatedAtAndUpdatedAtTrait;

    #[ORM\Id]
    #[ORM\Column(type: UuidType::NAME)]
    private Uuid $uuid;

    #[ORM\Column(name: 'first_name', type: FirstNameType::NAME, nullable: true)]
    private FirstName $firstName;

    #[ORM\Column(name: 'last_name', type: LastNameType::NAME, nullable: true)]
    private LastName $lastName;

    #[ORM\Column(type: EmailType::NAME)]
    private Email $email;

    #[ORM\Column(name: 'company_uuid', type: CompanyUuidType::NAME)]
    private CompanyUuid $companyUuid;

    private function __construct(Uuid $uuid, Email $email, CompanyUuid $companyUuid)
    {
        $this->uuid = $uuid;
        $this->firstName = FirstName::fromValue(null);
        $this->lastName = LastName::fromValue(null);
        $this->email = $email;
        $this->companyUuid = $companyUuid;
    }

    public static function create(Uuid $uuid, Email $email, CompanyUuid $companyUuid): self
    {
        $manager = new self($uuid, $email, $companyUuid);

        $manager->record(
            new ManagerWasCreatedDomainEvent(
                $manager->getUuid()->value,
                $manager->getEmail()->value,
                $manager->getCompanyUuid()->value
            )
        );

        return $manager;
    }

    public function delete(): void
    {
        $this->record(new ManagerWasDeletedDomainEvent($this->uuid->value, $this->companyUuid->value));
    }

    public function getUuid(): Uuid
    {
        return $this->uuid;
    }

    public function getFirstName(): FirstName
    {
        return $this->firstName;
    }

    public function getLastName(): LastName
    {
        return $this->lastName;
    }

    public function getEmail(): Email
    {
        return $this->email;
    }

    public function getCompanyUuid(): CompanyUuid
    {
        return $this->companyUuid;
    }

    public function toArray(): array
    {
        return [
            'uuid' => $this->uuid,
            'first_name' => $this->firstName,
            'last_name' => $this->lastName,
            'email' => $this->email,
        ];
    }
}
