<?php

declare(strict_types=1);

namespace Project\Domains\Student\Authentication\Domain\Code;

use DateTimeImmutable;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Project\Domains\Admin\Student\Domain\Student\Student;
use Project\Shared\Domain\Traits\CreatedAtAndUpdatedAtTrait;

#[ORM\Entity]
#[ORM\Table(name: 'student_auth_codes')]
#[ORM\HasLifecycleCallbacks]
class Code
{
    use CreatedAtAndUpdatedAtTrait;

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: Types::INTEGER)]
    private int $id;

    #[ORM\Column(type: Types::STRING, unique: true)]
    private string $value;

    #[ORM\Column(name: 'author_uuid', type: Types::GUID)]
    private ?string $authorUuid;

    #[ORM\OneToOne(targetEntity: Student::class, inversedBy: 'code')]
    #[ORM\JoinColumn(name: 'author_uuid', referencedColumnName: 'uuid', unique: true)]
    private ?Student $author;

    #[ORM\Column(name: 'expired_at', type: Types::DATETIME_IMMUTABLE)]
    private DateTimeImmutable $expiredAt;

    private function __construct(string $value, DateTimeImmutable $expiredAt)
    {
        $this->value = $value;
        $this->expiredAt = $expiredAt;
    }

    public static function fromPrimitives(string $value, DateTimeImmutable $expiredAt): self
    {
        return new self($value, $expiredAt);
    }

    public function setAuthor(?Student $author): self
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

    public function getAuthor(): Student
    {
        return $this->author;
    }

    public function getAuthorUuid(): string
    {
        return $this->authorUuid;
    }
}
