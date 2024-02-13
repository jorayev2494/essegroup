<?php

declare(strict_types=1);

namespace Project\Domains\Admin\University\Domain\Application\ValueObjects;

use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Event\PrePersistEventArgs;
use Doctrine\ORM\Event\PreUpdateEventArgs;
use Doctrine\ORM\Mapping as ORM;
use Project\Domains\Admin\University\Domain\Application\Application;
use Project\Domains\Admin\University\Domain\Application\StatusEnum;
use Project\Domains\Admin\University\Infrastructure\Application\Repositories\Doctrine\Types\StatusEnumType;
use Project\Shared\Contracts\ArrayableInterface;
use DateTimeImmutable;

#[ORM\Entity]
#[ORM\Table(name: 'university_application_statuses')]
#[ORM\HasLifecycleCallbacks]
class Status implements ArrayableInterface
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private int $id;

    #[ORM\Column(type: StatusEnumType::NAME, length: 20)]
    private StatusEnum $value;

    #[ORM\Column(type: Types::TEXT, length: 20, nullable: true)]
    private ?string $note;

    #[ORM\ManyToOne(targetEntity: Application::class, inversedBy: 'statues')]
    #[ORM\JoinColumn(name: 'application_uuid', referencedColumnName: 'uuid', nullable: false)]
    private Application $application;

    #[ORM\Column(name: 'created_at', type: Types::DATETIME_IMMUTABLE)]
    protected DateTimeImmutable $createdAt;

    #[ORM\Column(name: 'updated_at', type: Types::DATETIME_IMMUTABLE)]
    protected DateTimeImmutable $updatedAt;

    private function __construct(
        StatusEnum $value,
        ?string $note
    )
    {
        $this->value = $value;
        $this->note = $note;
    }

    public static function fromPrimitives(string $value, ?string $note = null): self
    {
        return new self(StatusEnum::from($value), $note);
    }

    public function getValue(): StatusEnum
    {
        return $this->value;
    }

    public function getNote(): ?string
    {
        return $this->note;
    }

    public function setNote(?string $note): void
    {
        $this->note = $note;
    }

    public function isEqualsValue(StatusEnum $value): bool
    {
        return $this->value->value === $value->value;
    }

    public function isEqualsNote(?string $note): bool
    {
        return $this->note === $note;
    }

    public function isNotEqualsValue(StatusEnum $value): bool
    {
        return $this->value->value !== $value->value;
    }

    public function isNotEqualsNote(?string $note): bool
    {
        return $this->note !== $note;
    }

    public function setApplication(Application $application): void
    {
        $this->application = $application;
    }

    #[ORM\PrePersist]
    public function prePersist(PrePersistEventArgs $event): void
    {
        $this->createdAt = new DateTimeImmutable();
        $this->updatedAt = new DateTimeImmutable();
    }

    #[ORM\PreUpdate]
    public function preUpdate(PreUpdateEventArgs $event): void
    {
        $this->updatedAt = new DateTimeImmutable();
    }

    #[\Override]
    public function toArray(): array
    {
        return [
            'value' => $this->value,
            'note' => $this->note,
            'created_at' => $this->createdAt->getTimestamp(),
            'updated_at' => $this->updatedAt->getTimestamp(),
        ];
    }

}
