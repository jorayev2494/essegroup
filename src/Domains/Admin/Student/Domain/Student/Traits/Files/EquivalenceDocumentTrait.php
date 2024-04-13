<?php

declare(strict_types=1);

namespace Project\Domains\Admin\Student\Domain\Student\Traits\Files;

use Doctrine\ORM\Mapping as ORM;
use Project\Domains\Admin\Student\Domain\Student\ValueObjects\Files\EquivalenceDocument;
use Project\Domains\Admin\Student\Infrastructure\Student\Services\Files\EquivalenceDocument\Contracts\EquivalenceDocumentInterface;

trait EquivalenceDocumentTrait
{
    #[ORM\ManyToOne(targetEntity: EquivalenceDocument::class, cascade: ['persist', 'remove'], inversedBy: 'application')]
    #[ORM\JoinColumn(name: 'equivalence_document_uuid', referencedColumnName: 'uuid', nullable: false)]
    private EquivalenceDocument $equivalenceDocument;

    #[\Override]
    public function getEquivalenceDocumentClassName(): string
    {
        return EquivalenceDocument::class;
    }

    #[\Override]
    public function getEquivalenceDocument(): EquivalenceDocument
    {
        return $this->equivalenceDocument;
    }

    #[\Override]
    public function changeEquivalenceDocument(EquivalenceDocumentInterface $equivalenceDocument): void
    {
        $this->equivalenceDocument = $equivalenceDocument;
    }

    #[\Override]
    public function deleteEquivalenceDocument(): void
    {
        // TODO: Implement deleteEquivalenceDocument() method.
    }
}
