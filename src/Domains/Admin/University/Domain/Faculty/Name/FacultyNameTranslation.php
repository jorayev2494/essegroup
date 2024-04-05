<?php

declare(strict_types=1);

namespace Project\Domains\Admin\University\Domain\Faculty\Name;

use Doctrine\ORM\Mapping as ORM;
use Project\Shared\Domain\Translation\AbstractTranslation;

/**
 * @property FacultyName $objectClass
 */
#[ORM\Entity]
#[ORM\Table(name: 'faculty_faculty_name_translations')]
#[ORM\UniqueConstraint(name: 'faculty_faculty_name_translation_idx', columns: ['locale', 'field', 'faculty_name_uuid'])]
class FacultyNameTranslation extends AbstractTranslation
{
    #[ORM\ManyToOne(targetEntity: FacultyName::class, fetch: 'LAZY', inversedBy: 'translations')]
    #[ORM\JoinColumn(name: 'faculty_name_uuid', referencedColumnName: 'uuid', onDelete: 'CASCADE')]
    protected $object;
}
