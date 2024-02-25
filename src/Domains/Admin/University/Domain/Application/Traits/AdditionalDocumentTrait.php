<?php

namespace Project\Domains\Admin\University\Domain\Application\Traits;

use Doctrine\Common\Collections\Collection;
use Project\Domains\Admin\University\Domain\Application\ValueObjects\AdditionalDocument;
use Project\Domains\Admin\University\Infrastructure\Application\Services\Files\AdditionalDocument\Contracts\AdditionalDocumentInterface;

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
        $additionalDocument->setApplication($this);
    }

    #[\Override]
    public function deleteAdditionalDocument(AdditionalDocumentInterface $additionalDocument): void
    {
        $this->additionalDocuments->removeElement($additionalDocument);
    }
}
