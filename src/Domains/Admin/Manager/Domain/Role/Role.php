<?php

declare(strict_types=1);

namespace Project\Domains\Admin\Manager\Domain\Role;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Project\Domains\Admin\Manager\Domain\Permission\Permission;
use Project\Domains\Admin\Manager\Domain\Role\ValueObjects\Name;
use Project\Domains\Admin\Manager\Domain\Role\ValueObjects\Uuid;
use Project\Domains\Admin\Manager\Infrastructure\Role\Repositories\Doctrine\Types\UuidType;
use Project\Domains\Admin\Manager\Infrastructure\Role\Repositories\Doctrine\Types\NameType;
use Project\Shared\Domain\Contracts\EntityUuid;
use Project\Shared\Domain\Traits\ActivableTrait;
use Project\Shared\Domain\Traits\CreatedAtAndUpdatedAtTrait;
use Project\Shared\Domain\Translation\TranslatableInterface;
use Project\Shared\Domain\Translation\TranslatableTrait;
use Project\Shared\Domain\ValueObject\UuidValueObject;
use Project\Shared\Infrastructure\Repository\Doctrine\Enums\FetchType;

#[ORM\Entity]
#[ORM\Table(name: 'manager_roles')]
#[ORM\HasLifecycleCallbacks]
class Role implements EntityUuid, TranslatableInterface
{
    use TranslatableTrait,
        ActivableTrait,
        CreatedAtAndUpdatedAtTrait;

    #[ORM\Id]
    #[ORM\Column(type: UuidType::NAME)]
    private Uuid $uuid;

    #[ORM\Column(type: NameType::NAME, nullable: true)]
    private Name $name;

    #[ORM\Column(name: 'is_admin', options: ['default' => false])]
    private bool $isAdmin;

    /**
     * @var RoleTranslation[] $translations
     */
    #[ORM\OneToMany(targetEntity: RoleTranslation::class, mappedBy: 'object', cascade: ['persist', 'remove'], fetch: FetchType::LAZY->value)]
    private Collection $translations;

    #[ORM\ManyToMany(targetEntity: Permission::class, inversedBy: 'contests')]
    #[ORM\JoinTable(
        name: 'manager_role_permission',
        joinColumns: new ORM\JoinColumn(name: 'role_uuid', referencedColumnName: 'uuid', nullable: false, onDelete: 'CASCADE'),
        inverseJoinColumns: new ORM\JoinColumn(name: 'permission_id', referencedColumnName: 'id', nullable: false, onDelete: 'CASCADE')
    )]
    private Collection $permissions;

    private function __construct(Uuid $uuid)
    {
        $this->uuid = $uuid;
        $this->name = Name::fromValue(null);
        $this->translations = new ArrayCollection();
        $this->permissions = new ArrayCollection();
        $this->isAdmin = false;
        $this->isActive = true;
    }

    public static function create(Uuid $uuid): self
    {
        return new self($uuid);
    }

    public function getUuid(): UuidValueObject
    {
        return $this->uuid;
    }

    public function getName(): Name
    {
        return $this->name;
    }

    public function setName(Name $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function isAdmin(): bool
    {
        return $this->isAdmin;
    }

    public function getPermissions(): array
    {
        return $this->permissions->toArray();
    }

    public function addPermission(Permission $permission): void
    {
        if (! $this->permissions->contains($permission)) {
            $this->permissions->add($permission);
        }
    }

    public function removePermission(Permission $permission): void
    {
        if ($this->permissions->contains($permission)) {
            $this->permissions->removeElement($permission);
        }
    }

    public function clearPermissions(): void
    {
        $this->permissions = new ArrayCollection();
    }

    public function getTranslationClass(): string
    {
        return RoleTranslation::class;
    }

    public function isNull(): bool
    {
        return $this->uuid->isNull();
    }

    public function isNotNull(): bool
    {
        return $this->uuid->isNotNull();
    }

    public function isEquals(self $other): bool
    {
        return $this->uuid->isEquals($other->uuid);
    }

    public function isNotEquals(self $other): bool
    {
        return $this->uuid->isNotEquals($other->uuid);
    }
}