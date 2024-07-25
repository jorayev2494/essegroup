<?php

declare(strict_types=1);

namespace Project\Domains\Admin\Manager\Domain\Role;

use Project\Shared\Domain\Translation\AbstractTranslation;
use Doctrine\ORM\Mapping as ORM;

/**
 * @property Role $objectClass
 */
#[ORM\Entity]
#[ORM\Table(name: 'manager_role_translations')]
#[ORM\UniqueConstraint(name: 'manager_role_translation_idx', columns: ['locale', 'role_uuid', 'field'])]
class RoleTranslation extends AbstractTranslation
{
    #[ORM\ManyToOne(targetEntity: Role::class, fetch: 'LAZY', inversedBy: 'translations', cascade: ['persist', 'remove'])]
    #[ORM\JoinColumn(name: 'role_uuid', referencedColumnName: 'uuid', onDelete: 'CASCADE')]
    protected $object;
}