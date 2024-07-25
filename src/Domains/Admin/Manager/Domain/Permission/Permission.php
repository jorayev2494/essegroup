<?php

declare(strict_types=1);

namespace Project\Domains\Admin\Manager\Domain\Permission;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Project\Domains\Admin\Manager\Domain\Permission\ValueObjects\Action;
use Project\Domains\Admin\Manager\Domain\Permission\ValueObjects\Id;
use Project\Domains\Admin\Manager\Domain\Permission\ValueObjects\Label;
use Project\Domains\Admin\Manager\Domain\Permission\ValueObjects\Resource;
use Project\Domains\Admin\Manager\Domain\Role\Role;
use Project\Domains\Admin\Manager\Infrastructure\Permission\Repositories\Doctrine\Types\ActionType;
use Project\Domains\Admin\Manager\Infrastructure\Permission\Repositories\Doctrine\Types\IdType;
use Project\Domains\Admin\Manager\Infrastructure\Permission\Repositories\Doctrine\Types\LabelType;
use Project\Domains\Admin\Manager\Infrastructure\Permission\Repositories\Doctrine\Types\ResourceType;
use Project\Shared\Domain\Contracts\EntityId;
use Project\Shared\Domain\Traits\ActivableTrait;
use Project\Shared\Domain\Traits\CreatedAtAndUpdatedAtTrait;
use Project\Shared\Domain\Translation\TranslatableInterface;
use Project\Shared\Domain\Translation\TranslatableTrait;
use Project\Shared\Domain\ValueObject\IdValueObject;

#[ORM\Entity]
#[
    ORM\Table(
        name: 'manager_role_permissions',
        indexes: [
            new ORM\Index(name: 'resource_idx', columns: ['resource']),
            new ORM\Index(name: 'action_idx', columns: ['action']),
        ]
    )
]
#[ORM\HasLifecycleCallbacks]
class Permission implements EntityId, TranslatableInterface
{
    use TranslatableTrait,
        ActivableTrait,
        CreatedAtAndUpdatedAtTrait;

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: IdType::NAME)]
    private Id $id;

    #[ORM\Column(type: LabelType::NAME, nullable: true)]
    private Label $label;

    #[ORM\Column(type: ResourceType::NAME)]
    private Resource $resource;

    #[ORM\Column(type: ActionType::NAME)]
    private Action $action;

    /**
     * @var PermissionTranslation[] $translations
     */
    #[ORM\OneToMany(targetEntity: PermissionTranslation::class, mappedBy: 'object', cascade: ['persist', 'remove'], fetch: 'LAZY')]
    private Collection $translations;

    #[ORM\ManyToMany(targetEntity: Role::class, mappedBy: 'permissions')]
    private Collection $roles;

    private function __construct(Resource $resource, Action $action)
    {
        $this->label = Label::fromValue(null);
        $this->resource = $resource;
        $this->action = $action;
        $this->translations = new ArrayCollection();
        $this->roles = new ArrayCollection();
    }

    public static function create(Resource $resource, Action $action): self
    {
        return new self($resource, $action);
    }

    public function getId(): IdValueObject
    {
        return $this->id;
    }

    public function getLabel(): Label
    {
        return $this->label;
    }

    public function setLabel(Label $label): self
    {
        $this->label = $label;

        return $this;
    }

    public function getResource(): Resource
    {
        return $this->resource;
    }

    public function getAction(): Action
    {
        return $this->action;
    }

    public function getTranslationClass(): string
    {
        return PermissionTranslation::class;
    }
}