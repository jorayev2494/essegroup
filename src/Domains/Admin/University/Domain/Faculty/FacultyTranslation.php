<?php

declare(strict_types=1);

namespace Project\Domains\Admin\University\Domain\Faculty;

use Doctrine\ORM\Mapping as ORM;
use Project\Shared\Domain\Translation\AbstractTranslation;

/**
 * @property Faculty $objectClass
 */
#[ORM\Entity]
#[ORM\Table(name: 'faculty_faculty_translations')]
#[ORM\UniqueConstraint(name: 'faculty_faculty_translation_idx', columns: ['locale', 'field', 'faculty_uuid'])]
class FacultyTranslation extends AbstractTranslation
{
    #[ORM\ManyToOne(targetEntity: Faculty::class, fetch: 'LAZY', inversedBy: 'translations', cascade: ['persist', 'remove'])]
    #[ORM\JoinColumn(name: 'faculty_uuid', referencedColumnName: 'uuid', onDelete: 'CASCADE')]
    protected $object;
}
