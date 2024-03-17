<?php

declare(strict_types=1);

namespace Project\Domains\Company\Authentication\Domain\Member;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Project\Domains\Company\Authentication\Domain\Code\Code;
use Project\Domains\Company\Authentication\Domain\Company\Company;
use Project\Domains\Company\Authentication\Domain\Device\Device;
use Project\Domains\Company\Authentication\Domain\Member\ValueObjects\Email;
use Project\Domains\Company\Authentication\Domain\Member\ValueObjects\Password;
use Project\Domains\Company\Authentication\Domain\Member\ValueObjects\Uuid;
use Project\Domains\Company\Authentication\Infrastructure\Repositories\Doctrine\Member\Types\EmailType;
use Project\Domains\Company\Authentication\Infrastructure\Repositories\Doctrine\Member\Types\PasswordType;
use Project\Domains\Company\Authentication\Infrastructure\Repositories\Doctrine\Member\Types\UuidType;
use Project\Infrastructure\Services\Authentication\Contracts\AuthenticatableInterface;
use Project\Shared\Domain\Aggregate\AggregateRoot;

#[ORM\Entity]
#[ORM\Table(name: 'auth_members')]
class Member extends AggregateRoot implements AuthenticatableInterface
{
    #[ORM\Id]
    #[ORM\Column(type: UuidType::NAME, unique: true)]
    private Uuid $uuid;

    #[ORM\Column(type: EmailType::NAME, unique: true)]
    private Email $email;

    #[ORM\Column(type: PasswordType::NAME)]
    private Password $password;

    #[ORM\OneToMany(targetEntity: Device::class, mappedBy: 'author', cascade: ['persist', 'remove'])]
    private Collection $devices;

    #[ORM\OneToOne(targetEntity: Code::class, mappedBy: 'author', orphanRemoval: true, cascade: ['persist', 'remove'])]
    public ?Code $code;

    #[ORM\Column(name: 'company_uuid')]
    private string $companyUuid;

    #[ORM\ManyToOne(targetEntity: Company::class, inversedBy: 'managers')]
    #[ORM\JoinColumn(name: 'company_uuid', referencedColumnName: 'uuid')]
    private Company $company;

    private function __construct(Uuid $uuid, Email $email, Password $password)
    {
        $this->uuid = $uuid;
        $this->email = $email;
        $this->password = $password;
        $this->devices = new ArrayCollection();
    }

    public static function fromPrimitives(string $uuid, string $email, string $password): self
    {
        return new self(
            Uuid::fromValue($uuid),
            Email::fromValue($email),
            Password::fromValue($password)
        );
    }

    public function changePassword(Password $password): void
    {
        $this->password = $password;
    }

    public function setCompany(Company $company): void
    {
        $this->company = $company;
    }

    public function getDevices(): Collection
    {
        return $this->devices;
    }

    public function addDevice(Device $device): void
    {
        $this->devices->add($device);
        $device->setAuthor($this);
    }

    public function getCode(): ?Code
    {
        return $this->code;
    }

    public function hasCode(): bool
    {
        return $this->code instanceof (Code::class);
    }

    public function addCode(Code $code): void
    {
        $code->setAuthor($this);
        $this->code = $code;
        // $this->record(new MemberRestorePasswordLinkWasAddedDomainEvent($this->uuid, $code->getValue(), $this->email));
    }

    public function removeCode(): void
    {
        $this->code?->setAuthor();
        $this->code = null;
    }

    #[\Override]
    public function getUuid(): string
    {
        return $this->uuid->value;
    }

    #[\Override]
    public function getClaims(): array
    {
        return [
            'company_uuid' => $this->companyUuid,
        ];
    }

    public function getCompany(): Company
    {
        return $this->company;
    }

    public function toArray(): array
    {
        return [
            'uuid' => $this->uuid->value,
            'email' => $this->email->value,
        ];
    }
}
