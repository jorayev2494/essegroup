<?php

declare(strict_types=1);

namespace Project\Domains\Admin\University\Infrastructure\Application\Services\Files\EquivalenceDocument\Contracts;

use Symfony\Component\HttpFoundation\File\UploadedFile;

interface EquivalenceDocumentServiceInterface
{
    public function upload(EquivalenceDocumentableInterface $equivalenceDocumentable, ?UploadedFile $uploadedFile): void;

    public function update(EquivalenceDocumentableInterface $equivalenceDocumentable, ?UploadedFile $uploadedFile): void;

    public function delete(EquivalenceDocumentableInterface $equivalenceDocumentable): void;
}
