<?php

declare(strict_types=1);

namespace Project\Domains\Admin\University\Domain\Department\Name;

use Doctrine\ORM\Mapping as ORM;
use Project\Shared\Domain\Translation\AbstractTranslation;

/**
 * @property DepartmentName $objectClass
 */
#[ORM\Entity]
#[ORM\Table(name: 'university_department_name_translations')]
#[ORM\UniqueConstraint(name: 'university_department_name_translation_idx', columns: ['locale', 'field', 'department_name_uuid'])]
class DepartmentNameTranslation extends AbstractTranslation
{
    #[ORM\ManyToOne(targetEntity: DepartmentName::class, fetch: 'LAZY', inversedBy: 'translations')]
    #[ORM\JoinColumn(name: 'department_name_uuid', referencedColumnName: 'uuid', onDelete: 'CASCADE')]
    protected $object;
}
