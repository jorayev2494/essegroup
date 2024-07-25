<?php

declare(strict_types=1);

namespace Project\Domains\Admin\Manager\Domain\Permission;

use Project\Domains\Admin\Manager\Domain\Role\Role;
use Project\Shared\Domain\Translation\AbstractTranslation;
use Doctrine\ORM\Mapping as ORM;

/**
 * @property Role $objectClass
 */
#[ORM\Entity]
#[ORM\Table(name: 'manager_role_permission_translations')]
#[ORM\UniqueConstraint(name: 'manager_role_permission_translation_idx', columns: ['locale', 'permission_id', 'field'])]
class PermissionTranslation extends AbstractTranslation
{
    #[ORM\ManyToOne(targetEntity: Permission::class, fetch: 'LAZY', inversedBy: 'translations', cascade: ['persist', 'remove'])]
    #[ORM\JoinColumn(name: 'permission_id', referencedColumnName: 'id', onDelete: 'CASCADE')]
    protected $object;
}