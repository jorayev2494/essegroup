<?php

declare(strict_types=1);

namespace Project\Domains\Admin\Company\Domain\University;

use Doctrine\ORM\Mapping as ORM;
use Project\Shared\Domain\Translation\AbstractTranslation;

/**
 * @property University $objectClass
 */
#[ORM\Entity]
#[ORM\Table('company_university_translations')]
#[ORM\UniqueConstraint(name: 'company_university_translation_idx', columns: ['locale', 'university_uuid', 'field'])]
class UniversityTranslation extends AbstractTranslation
{
    #[ORM\ManyToOne(targetEntity: University::class, fetch: 'LAZY', inversedBy: 'translations', cascade: ['persist', 'remove'])]
    #[ORM\JoinColumn(name: 'university_uuid', referencedColumnName: 'uuid', onDelete: 'CASCADE')]
    protected $object;
}
