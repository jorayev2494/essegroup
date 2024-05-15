<?php

declare(strict_types=1);

namespace Project\Domains\Admin\Contest\Domain\Contest;

use Doctrine\ORM\Mapping as ORM;
use Project\Domains\Admin\Country\Domain\Country\Country;
use Project\Shared\Domain\Translation\AbstractTranslation;

/**
 * @property Country $objectClass
 */
#[ORM\Entity]
#[ORM\Table(name: 'contest_contest_translations')]
#[ORM\UniqueConstraint(name: 'contest_contest_translation_idx', columns: ['locale', 'contest_uuid', 'field'])]
class ContestTranslation extends AbstractTranslation
{
    #[ORM\ManyToOne(targetEntity: Contest::class, fetch: 'LAZY', inversedBy: 'translations')]
    #[ORM\JoinColumn(name: 'contest_uuid', referencedColumnName: 'uuid', onDelete: 'CASCADE')]
    protected $object;
}
