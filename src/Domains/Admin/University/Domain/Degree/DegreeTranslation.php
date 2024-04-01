<?php

declare(strict_types=1);

namespace Project\Domains\Admin\University\Domain\Degree;

use Doctrine\ORM\Mapping as ORM;
use Project\Shared\Domain\Translation\AbstractTranslation;

#[ORM\Entity]
#[ORM\Table(name: 'university_degree_translations')]
#[ORM\UniqueConstraint(name: 'university_degree_translation_idx', columns: ['locale', 'field', 'degree_uuid'])]
class DegreeTranslation extends AbstractTranslation
{
    #[ORM\ManyToOne(targetEntity: Degree::class, fetch: 'LAZY', inversedBy: 'translations')]
    #[ORM\JoinColumn(name: 'degree_uuid', referencedColumnName: 'uuid', onDelete: 'CASCADE')]
    protected $object;
}
