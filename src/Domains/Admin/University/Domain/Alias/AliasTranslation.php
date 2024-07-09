<?php

declare(strict_types=1);

namespace Project\Domains\Admin\University\Domain\Alias;

use Doctrine\ORM\Mapping as ORM;
use Project\Shared\Domain\Translation\AbstractTranslation;

/**
 * @property Alias $objectClass
 */
#[ORM\Entity]
#[ORM\Table(name: 'university_alias_translations')]
#[ORM\UniqueConstraint(name: 'university_alias_translation_idx', columns: ['locale', 'alias_uuid', 'field'])]
class AliasTranslation extends AbstractTranslation
{
    #[ORM\ManyToOne(targetEntity: Alias::class, fetch: 'LAZY', inversedBy: 'translations', cascade: ['persist', 'remove'])]
    #[ORM\JoinColumn(name: 'alias_uuid', referencedColumnName: 'uuid', onDelete: 'CASCADE')]
    protected $object;
}
