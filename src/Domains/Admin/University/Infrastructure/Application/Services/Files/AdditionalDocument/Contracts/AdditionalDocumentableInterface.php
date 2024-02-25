<?php

declare(strict_types=1);

namespace Project\Domains\Admin\University\Infrastructure\Application\Services\Files\AdditionalDocument\Contracts;

use Doctrine\Common\Collections\Collection;

interface AdditionalDocumentableInterface
{
    public function getAdditionalDocumentName(): string;

    public function getAdditionalDocuments(): Collection;

    public function addAdditionalDocument(AdditionalDocumentInterface $additionalDocument): void;

    public function deleteAdditionalDocument(AdditionalDocumentInterface $additionalDocument): void;
}
