<?php

declare(strict_types=1);

namespace Project\Domains\Admin\Manager\Domain\Manager;

use DateTimeImmutable;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Event\PrePersistEventArgs;
use Doctrine\ORM\Mapping as ORM;
use Project\Domains\Admin\Announcement\Domain\Announcement\Announcement;
use Project\Domains\Admin\Authentication\Domain\Code\Code;
use Project\Domains\Admin\Authentication\Domain\Device\Device;
use Project\Domains\Admin\Manager\Domain\Manager\Events\ManagerWasCreatedDomainEvent;
use Project\Domains\Admin\Manager\Domain\Manager\Events\Restore\MemberRestorePasswordLinkWasAddedDomainEvent;
use Project\Domains\Admin\Manager\Domain\Manager\Services\Avatar\Contracts\AvatarableInterface;
use Project\Domains\Admin\Manager\Domain\Manager\Services\Avatar\Contracts\AvatarInterface;
use Project\Domains\Admin\Manager\Domain\Manager\ValueObjects\Avatar;
use Project\Domains\Admin\Manager\Domain\Manager\ValueObjects\Email;
use Project\Domains\Admin\Manager\Domain\Manager\ValueObjects\FirstName;
use Project\Domains\Admin\Manager\Domain\Manager\ValueObjects\FullName;
use Project\Domains\Admin\Manager\Domain\Manager\ValueObjects\LastName;
use Project\Domains\Admin\Manager\Domain\Manager\ValueObjects\Password;
use Project\Domains\Admin\Manager\Domain\Manager\ValueObjects\Uuid;
use Project\Domains\Admin\Manager\Infrastructure\Manager\Repositories\Doctrine\Types\EmailType;
use Project\Domains\Admin\Manager\Infrastructure\Manager\Repositories\Doctrine\Types\PasswordType;
use Project\Domains\Admin\Manager\Infrastructure\Manager\Repositories\Doctrine\Types\UuidType;
use Project\Infrastructure\Services\Authentication\Contracts\AuthenticatableInterface;
use Project\Shared\Domain\Aggregate\AggregateRoot;
use Project\Shared\Domain\Traits\CreatedAtAndUpdatedAtTrait;
use Project\Shared\Domain\ValueObject\UuidValueObject;

#[ORM\Entity]
#[ORM\Table(name: 'auth_members')]
#[ORM\HasLifecycleCallbacks]
class Manager extends AggregateRoot implements AuthenticatableInterface, AvatarableInterface
{
    use CreatedAtAndUpdatedAtTrait;

    #[ORM\Id]
    #[ORM\Column(type: UuidType::NAME, unique: true)]
    private Uuid $uuid;

    #[ORM\Embedded(class: FullName::class, columnPrefix: false)]
    private FullName $fullName;

    #[ORM\Column(type: EmailType::NAME, unique: true)]
    private Email $email;

    #[ORM\Column(name: 'avatar_uuid', type: Types::GUID, nullable: true)]
    private ?string $avatarUuid;

    #[ORM\OneToOne(targetEntity: Avatar::class, inversedBy: 'manager', cascade: ['persist', 'remove'])]
    #[ORM\JoinColumn(name: 'avatar_uuid', referencedColumnName: 'uuid', onDelete: 'SET NULL')]
    private ?Avatar $avatar;

    #[ORM\Column(type: PasswordType::NAME)]
    private Password $password;

    #[ORM\OneToMany(targetEntity: Device::class, mappedBy: 'author', cascade: ['persist', 'remove'])]
    private Collection $devices;

    #[ORM\OneToOne(targetEntity: Code::class, mappedBy: 'author', cascade: ['persist', 'remove'], orphanRemoval: true)]
    public ?Code $code;

    #[ORM\OneToMany(targetEntity: Announcement::class, mappedBy: 'author', cascade: ['persist', 'remove'])]
    private Collection $announcements;

    private function __construct(Uuid $uuid, FullName $fullName, Email $email, Password $password)
    {
        $this->uuid = $uuid;
        $this->fullName = $fullName;
        $this->email = $email;
        $this->password = $password;
        $this->avatar = null;
        $this->devices = new ArrayCollection();
        $this->announcements = new ArrayCollection();
    }

    public static function create(Uuid $uuid, FullName $fullName, Email $email, Password $password): self
    {
        $manager = new self($uuid, $fullName, $email, $password);
        $manager->record(
            new ManagerWasCreatedDomainEvent(
                $uuid->value,
                $fullName->getFirstName()->value,
                $fullName->getLastName()->value,
                $email->value,
                $password->value
            )
        );

        return $manager;
    }

    public static function fromPrimitives(string $uuid, string $firstName, string $lastName, string $email, string $password): self
    {
        return new self(
            Uuid::fromValue($uuid),
            FullName::make(
                FirstName::fromValue($firstName),
                LastName::fromValue($lastName)
            ),
            Email::fromValue($email),
            Password::fromValue($password)
        );
    }

    public function changePassword(Password $password): void
    {
        $this->password = $password;
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
        $this->record(new MemberRestorePasswordLinkWasAddedDomainEvent($this->uuid->value, $this->email->value, $code->getValue()));
    }

    public function removeCode(): void
    {
        $this->code?->setAuthor();
        $this->code = null;
    }

    public function getFullName(): FullName
    {
        return $this->fullName;
    }

    #[\Override]
    public function getUuid(): UuidValueObject
    {
        return $this->uuid;
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

    public function changeEmail(Email $email): self
    {
        if ($this->email->isNotEquals($email)) {
            $this->email = $email;
        }

        return $this;
    }

    public function deleteAvatar(): static
    {
        return $this;
    }

    #[\Override]
    public function getClaims(): array
    {
        return [

        ];
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
            'avatar' => $this->avatar?->toArray(),
            'email' => $this->email->value,
            'created_at' => $this->createdAt->getTimestamp(),
            'updated_at' => $this->updatedAt->getTimestamp(),
        ];
    }
}