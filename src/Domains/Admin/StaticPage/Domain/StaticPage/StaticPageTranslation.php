<?php

declare(strict_types=1);

namespace Project\Domains\Admin\StaticPage\Domain\StaticPage;

use Doctrine\ORM\Mapping as ORM;
use Project\Shared\Domain\Translation\AbstractTranslation;

/**
 * @property StaticPage $objectClass
 */
#[ORM\Entity]
#[ORM\Table(name: 'static_page_static_page_translations')]
#[ORM\UniqueConstraint(name: 'static_page_static_page_translation_idx', columns: ['locale', 'static_page_uuid', 'field'])]
class StaticPageTranslation extends AbstractTranslation
{
    #[ORM\ManyToOne(targetEntity: StaticPage::class, fetch: 'LAZY', inversedBy: 'translations', cascade: ['persist', 'remove'])]
    #[ORM\JoinColumn(name: 'static_page_uuid', referencedColumnName: 'uuid', onDelete: 'CASCADE')]
    protected $object;
}
