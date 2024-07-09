<?php

declare(strict_types=1);

namespace Project\Domains\Admin\University\Domain\Faculty\Name;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Project\Domains\Admin\University\Domain\Faculty\Faculty;
use Project\Domains\Admin\University\Domain\Faculty\Name\ValueObjects\Uuid;
use Project\Domains\Admin\University\Domain\Faculty\Name\ValueObjects\Value;
use Project\Domains\Admin\University\Infrastructure\Repositories\Doctrine\Faculty\Name\Types\UuidType;
use Project\Domains\Admin\University\Infrastructure\Repositories\Doctrine\Faculty\Name\Types\ValueType;
use Project\Shared\Contracts\ArrayableInterface;
use Project\Shared\Domain\Contracts\EntityUuid;
use Project\Shared\Domain\Traits\ActivableTrait;
use Project\Shared\Domain\Traits\CreatedAtAndUpdatedAtTrait;
use Project\Shared\Domain\Translation\TranslatableInterface;
use Project\Shared\Domain\Translation\TranslatableTrait;
use Project\Shared\Domain\ValueObject\UuidValueObject;

#[ORM\Entity]
#[ORM\Table(name: 'faculty_faculty_names')]
#[ORM\HasLifecycleCallbacks]
class FacultyName implements EntityUuid, TranslatableInterface, ArrayableInterface
{
    use TranslatableTrait, ActivableTrait, CreatedAtAndUpdatedAtTrait;

    #[ORM\Id]
    #[ORM\Column(type: UuidType::NAME)]
    private Uuid $uuid;

    #[ORM\Column(type: ValueType::NAME, nullable: true)]
    private Value $value;

    #[ORM\OneToMany(targetEntity: FacultyNameTranslation::class, mappedBy: 'object', cascade: ['persist', 'remove'], fetch: 'EAGER')]
    private Collection $translations;

    #[ORM\OneToMany(targetEntity: Faculty::class, mappedBy: 'name')]
    private Collection $faculties;

    private function __construct(Uuid $uuid, bool $isActive)
    {
        $this->uuid = $uuid;
        $this->value = Value::fromValue(null);
        $this->translations = new ArrayCollection();
        $this->faculties = new ArrayCollection();
        $this->isActive = $isActive;
    }

    public static function create(Uuid $uuid, bool $isActive): self
    {
        return new self($uuid, $isActive);
    }

    public function getUuid(): UuidValueObject
    {
        return $this->uuid;
    }

    public function getValue(): Value
    {
        return $this->value;

    }

    public function setValue(Value $value): self
    {
        $this->value = $value;

        return $this;
    }

    public function getTranslationClass(): string
    {
        return FacultyNameTranslation::class;
    }

    public function toArray(): array
    {
        return [
            'uuid' => $this->uuid->value,
            'value' => $this->value->value,
            'created_at' => $this->createdAt->getTimestamp(),
            'updated_at' => $this->updatedAt->getTimestamp(),
        ];
    }
}
