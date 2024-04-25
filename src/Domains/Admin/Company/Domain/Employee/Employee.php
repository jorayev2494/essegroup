<?php

declare(strict_types=1);

namespace Project\Domains\Admin\Company\Domain\Employee;

use DateTimeImmutable;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Event\PrePersistEventArgs;
use Doctrine\ORM\Mapping as ORM;
use Project\Domains\Admin\Company\Domain\Company\Company;
use Project\Domains\Admin\Company\Domain\Employee\Services\Avatar\Contracts\AvatarableInterface;
use Project\Domains\Admin\Company\Domain\Employee\Services\Avatar\Contracts\AvatarInterface;
use Project\Domains\Admin\Company\Domain\Employee\ValueObjects\Avatar;
use Project\Domains\Admin\Company\Domain\Employee\ValueObjects\Email;
use Project\Domains\Admin\Company\Domain\Employee\ValueObjects\FullName;
use Project\Domains\Admin\Company\Domain\Employee\ValueObjects\Password;
use Project\Domains\Admin\Company\Domain\Employee\ValueObjects\Uuid;
use Project\Domains\Admin\Company\Infrastructure\Employee\Repositories\Types\EmailType;
use Project\Domains\Admin\Company\Infrastructure\Employee\Repositories\Types\PasswordType;
use Project\Domains\Admin\Company\Infrastructure\Employee\Repositories\Types\UuidType;
use Project\Domains\Company\Authentication\Domain\Code\Code;
use Project\Domains\Company\Authentication\Domain\Device\Device;
use Project\Infrastructure\Services\Authentication\Contracts\AuthenticatableInterface;
use Project\Shared\Domain\Traits\ActivableTrait;
use Project\Shared\Domain\Traits\CreatedAtAndUpdatedAtTrait;

#[ORM\Entity]
#[ORM\Table(name: 'company_employees')]
#[ORM\HasLifecycleCallbacks]
class Employee implements AuthenticatableInterface, AvatarableInterface
{
    use ActivableTrait, CreatedAtAndUpdatedAtTrait;

    #[ORM\Id]
    #[ORM\Column(type: UuidType::NAME)]
    private Uuid $uuid;

    #[ORM\Embedded(class: FullName::class, columnPrefix: false)]
    private FullName $fullName;

    #[ORM\Column(type: EmailType::NAME, length: 50)]
    private Email $email;

    #[ORM\Column(name: 'avatar_uuid', type: Types::GUID, nullable: true)]
    private ?string $avatarUuid;

    #[ORM\OneToOne(targetEntity: Avatar::class, inversedBy: 'employee', cascade: ['persist', 'remove'])]
    #[ORM\JoinColumn(name: 'avatar_uuid', referencedColumnName: 'uuid', onDelete: 'SET NULL')]
    private ?Avatar $avatar;

    #[ORM\Column(type: PasswordType::NAME, length: 100)]
    private Password $password;

    #[ORM\Column(name: 'company_uuid', type: Types::GUID, nullable: true)]
    private ?string $companyUuid;

    #[ORM\ManyToOne(targetEntity: Company::class, inversedBy: 'employees')]
    #[ORM\JoinColumn(name: 'company_uuid', referencedColumnName: 'uuid', onDelete: 'SET NULL')]
    private Company $company;

    #[ORM\OneToMany(targetEntity: Device::class, mappedBy: 'author', cascade: ['persist', 'remove'])]
    private Collection $devices;

    #[ORM\OneToOne(targetEntity: Code::class, mappedBy: 'author', cascade: ['persist', 'remove'], orphanRemoval: true)]
    public ?Code $code;

    private function __construct(Uuid $uuid, FullName $fullName, Email $email, Password $password)
    {
        $this->uuid = $uuid;
        $this->fullName = $fullName;
        $this->email = $email;
        $this->password = $password;
        $this->avatar = null;
        $this->devices = new ArrayCollection();
        $this->isActive = true;
    }

    public static function create(Uuid $uuid, FullName $fullName, Email $email, Password $password): self
    {
        return new self($uuid, $fullName, $email, $password);
    }

    public function getUuid(): Uuid
    {
        return $this->uuid;
    }

    public function getFullName(): FullName
    {
        return $this->fullName;
    }

    public function changeEmail(Email $email): self
    {
        if ($this->email->isNotEquals($email)) {
            $this->email = $email;
        }

        return $this;
    }

    public function setAvatar(Avatar $avatar): self
    {
        $this->avatar = $avatar;

        return $this;
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
        $this->code = $code;
        $code->setAuthor($this);
        // $this->record(new MemberRestorePasswordLinkWasAddedDomainEvent($this->uuid, $code->getValue(), $this->email));
    }

    public function removeCode(): void
    {
        $this->code?->setAuthor(null);
        $this->code = null;
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

    public function getAvatar(): ?AvatarInterface
    {
        return $this->avatar;
    }

    public function changeAvatar(?AvatarInterface $avatar): static
    {
        if ($this->avatar === null || $this->avatar->isNotEquals($avatar)) {
            $this->avatar = $avatar;
        }

        return $this;
    }

    public function deleteAvatar(): static
    {
        return $this;
    }

    public function isEqual(self $other): bool
    {
        return $this->uuid->value === $other->getUuid()->value;
    }

    public function isNotEqual(self $other): bool
    {
        return $this->uuid->value !== $other->getUuid()->value;
    }

    #[ORM\PrePersist]
    public function prePersisting(PrePersistEventArgs $event): void
    {
        $this->createdAt = $this->createdAt ?? new DateTimeImmutable();
        $this->updatedAt = new DateTimeImmutable();

        if ($this->createdAt->getTimestamp() === $this->updatedAt->getTimestamp()) {
            $this->password = Password::fromValue($this->password->hash());
        }
    }

    public function toArray(): array
    {
        return [
            'uuid' => $this->uuid->value,
            ...$this->fullName->toArray(),
            'email' => $this->email->value,
            'avatar' => $this->avatar?->toArray(),
            'company_uuid' => $this->companyUuid,
            'company' => $this->company?->toArray(),
            'created_at' => $this->createdAt->getTimestamp(),
            'updated_at' => $this->updatedAt->getTimestamp(),
        ];
    }
}
