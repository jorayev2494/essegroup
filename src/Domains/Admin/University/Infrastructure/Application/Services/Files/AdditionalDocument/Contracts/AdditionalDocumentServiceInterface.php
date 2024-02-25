<?php

declare(strict_types=1);

namespace Project\Domains\Admin\University\Infrastructure\Application\Services\Files\AdditionalDocument\Contracts;

interface AdditionalDocumentServiceInterface
{
    public function uploadDocuments(AdditionalDocumentableInterface $additionalDocumentable, array $documents): void;

    public function deleteDocuments(AdditionalDocumentableInterface $additionalDocumentable): void;
}
