<?php

declare(strict_types=1);

namespace Project\Domains\Admin\Country\Domain\City;

use Doctrine\ORM\Mapping as ORM;
use Project\Shared\Domain\Translation\AbstractTranslation;

/**
 * @property City $objectClass
 */
#[ORM\Entity]
#[ORM\Table('country_city_translations')]
#[ORM\UniqueConstraint(name: 'country_city_translation_idx', columns: ['locale', 'city_uuid', 'field'])]
class CityTranslation extends AbstractTranslation
{
    #[ORM\ManyToOne(targetEntity: City::class, fetch: 'LAZY', inversedBy: 'translations', cascade: ['persist', 'remove'])]
    #[ORM\JoinColumn(name: 'city_uuid', referencedColumnName: 'uuid', onDelete: 'CASCADE')]
    protected $object;
}
