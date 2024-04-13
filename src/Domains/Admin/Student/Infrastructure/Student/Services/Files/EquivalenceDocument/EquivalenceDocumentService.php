<?php

declare(strict_types=1);

namespace Project\Domains\Admin\Student\Infrastructure\Student\Services\Files\EquivalenceDocument;

use Project\Domains\Admin\Student\Domain\Student\ValueObjects\Files\EquivalenceDocument;
use Project\Domains\Admin\Student\Infrastructure\Student\Services\Files\EquivalenceDocument\Contracts\EquivalenceDocumentableInterface;
use Project\Domains\Admin\Student\Infrastructure\Student\Services\Files\EquivalenceDocument\Contracts\EquivalenceDocumentServiceInterface;
use Project\Shared\Domain\File\FileSystemInterface;
use Symfony\Component\HttpFoundation\File\UploadedFile;

readonly class EquivalenceDocumentService implements EquivalenceDocumentServiceInterface
{
    function __construct(
        private FileSystemInterface $fileSystem,
    )
    {

    }

    public function upload(EquivalenceDocumentableInterface $equivalenceDocumentable, ?UploadedFile $uploadedFile): void
    {
        if ($uploadedFile === null) {
            return;
        }

        /** @var EquivalenceDocument $equivalenceDocument */
        $equivalenceDocument = $this->fileSystem->upload($equivalenceDocumentable->getEquivalenceDocumentClassName(), $uploadedFile);
        $equivalenceDocumentable->changeEquivalenceDocument($equivalenceDocument);
    }

    public function update(EquivalenceDocumentableInterface $equivalenceDocumentable, ?UploadedFile $uploadedFile): void
    {
        if ($uploadedFile !== null) {
            $this->delete($equivalenceDocumentable);
            $this->upload($equivalenceDocumentable, $uploadedFile);
        }
    }

    public function delete(EquivalenceDocumentableInterface $equivalenceDocumentable): void
    {
        $this->fileSystem->delete($equivalenceDocumentable->getEquivalenceDocument());
        $equivalenceDocumentable->deleteEquivalenceDocument();
    }
}
