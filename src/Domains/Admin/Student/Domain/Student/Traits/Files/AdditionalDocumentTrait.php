<?php

namespace Project\Domains\Admin\Student\Domain\Student\Traits\Files;

use Doctrine\Common\Collections\Collection;
use Project\Domains\Admin\Student\Domain\Student\ValueObjects\Files\AdditionalDocument;
use Project\Domains\Admin\Student\Infrastructure\Student\Services\Files\AdditionalDocument\Contracts\AdditionalDocumentInterface;

trait AdditionalDocumentTrait
{
    #[\Override]
    public function getAdditionalDocumentName(): string
    {
        return AdditionalDocument::class;
    }

    #[\Override]
    public function getAdditionalDocuments(): Collection
    {
        return $this->additionalDocuments;
    }

    #[\Override]
    public function addAdditionalDocument(AdditionalDocumentInterface $additionalDocument): void
    {
        $this->additionalDocuments->add($additionalDocument);
        $additionalDocument->setStudent($this);
    }

    #[\Override]
    public function deleteAdditionalDocument(AdditionalDocumentInterface $additionalDocument): void
    {
        $this->additionalDocuments->removeElement($additionalDocument);
    }
}
