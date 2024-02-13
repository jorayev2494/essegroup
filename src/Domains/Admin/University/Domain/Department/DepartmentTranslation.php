<?php

declare(strict_types=1);

namespace Project\Domains\Admin\University\Domain\Department;

use Doctrine\ORM\Mapping as ORM;
use Project\Shared\Domain\Translation\AbstractTranslation;

#[ORM\Entity]
#[ORM\Table('university_department_translations')]
#[ORM\UniqueConstraint(name: 'university_department_translation_idx', columns: ['locale', 'field', 'department_uuid'])]
class DepartmentTranslation extends AbstractTranslation
{
    #[ORM\ManyToOne(targetEntity: Department::class, fetch: 'LAZY', inversedBy: 'translations', cascade: ['persist', 'remove'])]
    #[ORM\JoinColumn(name: 'department_uuid', referencedColumnName: 'uuid', onDelete: 'CASCADE')]
    protected $object;
}
