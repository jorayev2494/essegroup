<?php

declare(strict_types=1);

namespace Project\Domains\Company\Authentication\Domain\Device;

use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Project\Domains\Company\Authentication\Domain\Member\Member;
use Project\Infrastructure\Services\Authentication\Contracts\DeviceInterface;
use Project\Shared\Domain\Traits\CreatedAtAndUpdatedAtTrait;

#[ORM\Entity]
#[ORM\Table('auth_devices')]
#[ORM\HasLifecycleCallbacks]
class Device implements DeviceInterface
{
    use CreatedAtAndUpdatedAtTrait;

    #[ORM\Id]
    #[ORM\Column(type: Types::STRING)]
    private string $uuid;

    #[ORM\Column(name: 'refresh_token', type: Types::STRING, unique: true)]
    private string $refreshToken;

    #[ORM\Column(name: 'device_id', type: Types::STRING)]
    private string $deviceId;

    #[ORM\Column(type: Types::STRING, nullable: true)]
    private string $os;

    #[ORM\Column(name: 'os_version', type: Types::STRING, nullable: true)]
    private string $osVersion;

    #[ORM\Column(name: 'app_version', type: Types::STRING, nullable: true)]
    private string $appVersion;

    #[ORM\Column(name: 'ip_address', type: Types::STRING, nullable: true)]
    private string $idAddress;

    #[ORM\Column(name: 'author_uuid', type: Types::STRING)]
    private string $authorUuid;

    #[ORM\ManyToOne(targetEntity: Member::class, inversedBy: 'devices', cascade: ['persist'])]
    #[ORM\JoinColumn(name: 'author_uuid', referencedColumnName: 'uuid', nullable: false)]
    private Member $author;

    private function __construct(
        string $uuid,
        string $refreshToken,
        string $deviceId,
    ) {
        $this->uuid = $uuid;
        $this->refreshToken = $refreshToken;
        $this->deviceId = $deviceId;
    }

    public static function fromPrimitives(string $uuid, string $refreshToken, string $deviceId): self
    {
        return new self($uuid, $refreshToken, $deviceId);
    }

    public function getUuid(): string
    {
        return $this->uuid;
    }

    public function getAuthor(): Member
    {
        return $this->author;
    }

    public function setAuthor(Member $author): self
    {
        $this->author = $author;

        return $this;
    }

    public function getAuthorUuid(): string
    {
        return $this->authorUuid;
    }

    public function getRefreshToken(): string
    {
        return $this->refreshToken;
    }

    public function setRefreshToken(string $refreshToken): self
    {
        $this->refreshToken = $refreshToken;

        return $this;
    }

    public function getDeviceId(): string
    {
        return $this->deviceId;
    }

    public function setDeviceId(string $deviceId): self
    {
        $this->deviceId = $deviceId;

        return $this;
    }

    public function toArray(): array
    {
        return [
            'uuid' => $this->uuid,
            'author' => $this->author->toArray(),
        ];
    }
}
