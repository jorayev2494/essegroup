<?php

declare(strict_types=1);

namespace Project\Domains\Admin\University\Domain\Department\Name;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Project\Domains\Admin\University\Domain\Department\Department;
use Project\Domains\Admin\University\Domain\Department\Name\ValueObjects\Description;
use Project\Domains\Admin\University\Domain\Department\Name\ValueObjects\Uuid;
use Project\Domains\Admin\University\Domain\Department\Name\ValueObjects\Value;
use Project\Domains\Admin\University\Infrastructure\Repositories\Doctrine\Department\Name\Types\UuidType;
use Project\Domains\Admin\University\Infrastructure\Repositories\Doctrine\Department\Name\Types\ValueType;
use Project\Domains\Admin\University\Infrastructure\Repositories\Doctrine\Department\Name\Types\DescriptionType;
use Project\Shared\Contracts\ArrayableInterface;
use Project\Shared\Domain\Contracts\EntityUuid;
use Project\Shared\Domain\Traits\ActivableTrait;
use Project\Shared\Domain\Traits\CreatedAtAndUpdatedAtTrait;
use Project\Shared\Domain\Translation\TranslatableInterface;
use Project\Shared\Domain\Translation\TranslatableTrait;
use Project\Shared\Domain\ValueObject\UuidValueObject;


#[ORM\Entity]
#[ORM\Table(name: 'university_department_names')]
#[ORM\HasLifecycleCallbacks]
class DepartmentName implements EntityUuid, TranslatableInterface, ArrayableInterface
{
    use TranslatableTrait, ActivableTrait, CreatedAtAndUpdatedAtTrait;

    #[ORM\Id]
    #[ORM\Column(type: UuidType::NAME)]
    private Uuid $uuid;

    #[ORM\Column(type: ValueType::NAME, nullable: true)]
    private Value $value;

    #[ORM\Column(type: DescriptionType::NAME, nullable: true)]
    private Description $description;

    #[ORM\OneToMany(targetEntity: DepartmentNameTranslation::class, mappedBy: 'object', cascade: ['persist', 'remove'], fetch: 'EAGER')]
    private Collection $translations;

    #[ORM\OneToMany(targetEntity: Department::class, mappedBy: 'name')]
    private Collection $departments;

    private function __construct(Uuid $uuid, bool $isActive)
    {
        $this->uuid = $uuid;
        $this->value = Value::fromValue(null);
        $this->description = Description::fromValue(null);
        $this->translations = new ArrayCollection();
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

    public function setValue(Value $value): self
    {
        $this->value = $value;

        return $this;
    }

    public function setDescription(Description $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getTranslationClass(): string
    {
        return DepartmentNameTranslation::class;
    }

    public function toArray(): array
    {
        return [
            'uuid' => $this->uuid->value,
            'value' => $this->value->value,
            'description' => $this->description->value,
            'created_at' => $this->createdAt->getTimestamp(),
            'updated_at' => $this->updatedAt->getTimestamp(),
        ];
    }
}
