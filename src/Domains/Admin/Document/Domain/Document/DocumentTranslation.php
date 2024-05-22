<?php

declare(strict_types=1);

namespace Project\Domains\Admin\Document\Domain\Document;

use Doctrine\ORM\Mapping as ORM;
use Project\Shared\Domain\Translation\AbstractTranslation;

/**
 * @property Document $objectClass
 */
#[ORM\Entity]
#[ORM\Table(name: 'document_document_translations')]
#[ORM\UniqueConstraint(name: 'document_document_translation_idx', columns: ['locale', 'document_uuid', 'field'])]
class DocumentTranslation extends AbstractTranslation
{
    #[ORM\ManyToOne(targetEntity: Document::class, fetch: 'LAZY', inversedBy: 'translations')]
    #[ORM\JoinColumn(name: 'document_uuid', referencedColumnName: 'uuid', onDelete: 'CASCADE')]
    protected $object;
}
