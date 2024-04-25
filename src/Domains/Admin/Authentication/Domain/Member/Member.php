<?php

declare(strict_types=1);

namespace Project\Domains\Admin\Authentication\Domain\Member;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Project\Domains\Admin\Authentication\Domain\Code\Code;
use Project\Domains\Admin\Authentication\Domain\Device\Device;
use Project\Domains\Admin\Authentication\Domain\Member\Events\Restore\MemberRestorePasswordLinkWasAddedDomainEvent;
use Project\Domains\Admin\Authentication\Domain\Member\ValueObjects\Email;
use Project\Domains\Admin\Authentication\Domain\Member\ValueObjects\Password;
use Project\Domains\Admin\Authentication\Domain\Member\ValueObjects\Uuid;
use Project\Domains\Admin\Authentication\Infrastructure\Repositories\Doctrine\Member\Types\EmailType;
use Project\Domains\Admin\Authentication\Infrastructure\Repositories\Doctrine\Member\Types\PasswordType;
use Project\Domains\Admin\Authentication\Infrastructure\Repositories\Doctrine\Member\Types\UuidType;
use Project\Infrastructure\Services\Authentication\Contracts\AuthenticatableInterface;
use Project\Shared\Domain\Aggregate\AggregateRoot;
use Project\Shared\Domain\ValueObject\UuidValueObject;

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

    #[ORM\OneToOne(targetEntity: Code::class, mappedBy: 'author', cascade: ['persist', 'remove'], orphanRemoval: true)]
    public ?Code $code;

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

    #[\Override]
    public function getUuid(): UuidValueObject
    {
        return $this->uuid;
    }

    #[\Override]
    public function getClaims(): array
    {
        return [

        ];
    }

    public function toArray(): array
    {
        return [
            'uuid' => $this->uuid->value,
            'email' => $this->email->value,
        ];
    }
}
