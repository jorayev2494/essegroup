<?php

declare(strict_types=1);

namespace Project\Domains\Admin\Authentication\Domain\Code;

use Doctrine\ORM\Mapping as ORM;
use DateTimeImmutable;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Event\PrePersistEventArgs;
use Doctrine\ORM\Event\PreUpdateEventArgs;
use Project\Domains\Admin\Authentication\Domain\Member\Member;

#[ORM\Entity]
#[ORM\Table(name: 'auth_codes')]
#[ORM\HasLifecycleCallbacks]
class Code
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: Types::INTEGER)]
    private int $id;

    #[ORM\Column(type: Types::STRING, unique: true)]
    private string $value;

    #[ORM\Column(name: 'author_uuid', type: Types::STRING)]
    private ?string $authorUuid;

    #[ORM\OneToOne(targetEntity: Member::class, inversedBy: 'code', cascade: ['persist', 'remove'])]
    #[ORM\JoinColumn(name: 'author_uuid', referencedColumnName: 'uuid', unique: true)]
    private ?Member $author;

    #[ORM\Column(name: 'expired_at', type: Types::DATETIME_IMMUTABLE)]
    private DateTimeImmutable $expiredAt;

    #[ORM\Column(name: 'created_at', type: Types::DATETIME_IMMUTABLE)]
    private DateTimeImmutable $createdAt;

    #[ORM\Column(name: 'updated_at', type: Types::DATETIME_IMMUTABLE)]
    private DateTimeImmutable $updatedAt;

    private function __construct(string $value, DateTimeImmutable $expiredAt)
    {
        $this->value = $value;
        $this->expiredAt = $expiredAt;
    }

    public static function fromPrimitives(string $value, DateTimeImmutable $expiredAt): self
    {
        return new self($value, $expiredAt);
    }

    public function setAuthor(?Member $author = null): self
    {
        $this->author = $author;

        return $this;
    }

    public function getValue(): string
    {
        return $this->value;
    }

    public function setValue(string $value): self
    {
        $this->value = $value;

        return $this;
    }

    public function getExpiredAt(): DateTimeImmutable
    {
        return $this->expiredAt;
    }

    public function setExpiredAt(string $value): self
    {
        $this->value = $value;

        return $this;
    }

    public function getAuthor(): Member
    {
        return $this->author;
    }

    public function getAuthorUuid(): string
    {
        return $this->authorUuid;
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
            'id' => $this->id,
            'author_uuid' => $this->authorUuid,
            'value' => $this->value,
            'author' => $this->author->toArray(),
            'expired_at' => $this->expiredAt->getTimestamp(),
        ];
    }
}
