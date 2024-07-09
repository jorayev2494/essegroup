<?php

declare(strict_types=1);

namespace Project\Domains\Admin\Language\Domain\Language;

use Doctrine\ORM\Mapping as ORM;
use Project\Shared\Domain\Translation\AbstractTranslation;

/**
 * @property Language $objectClass
 */
#[ORM\Entity]
#[ORM\Table(name: 'language_language_translations')]
#[ORM\UniqueConstraint(name: 'language_language_translation_idx', columns: ['locale', 'language_uuid', 'field'])]
class LanguageTranslation extends AbstractTranslation
{
    #[ORM\ManyToOne(targetEntity: Language::class, fetch: 'LAZY', inversedBy: 'translations', cascade: ['persist', 'remove'])]
    #[ORM\JoinColumn(name: 'language_uuid', referencedColumnName: 'uuid', onDelete: 'CASCADE')]
    protected $object;
}
