<?php

declare(strict_types=1);

namespace Project\Domains\Admin\Country\Domain\Country;

use Doctrine\ORM\Mapping as ORM;
use Project\Shared\Domain\Translation\AbstractTranslation;

/**
 * @property Country $objectClass
 */
#[ORM\Entity]
#[ORM\Table(name: 'country_country_translations')]
#[ORM\UniqueConstraint(name: 'country_country_translation_idx', columns: ['locale', 'country_uuid', 'field'])]
class CountryTranslation extends AbstractTranslation
{
    #[ORM\ManyToOne(targetEntity: Country::class, fetch: 'LAZY', inversedBy: 'translations', cascade: ['persist', 'remove'])]
    #[ORM\JoinColumn(name: 'country_uuid', referencedColumnName: 'uuid', onDelete: 'CASCADE')]
    protected $object;
}
