<?php

declare(strict_types=1);

namespace Project\Domains\Admin\Student\Infrastructure\Student\Services\Files\AdditionalDocument;

use Illuminate\Support\Facades\Log;
use Project\Domains\Admin\Student\Infrastructure\Student\Services\Files\AdditionalDocument\Contracts\AdditionalDocumentableInterface;
use Project\Domains\Admin\Student\Infrastructure\Student\Services\Files\AdditionalDocument\Contracts\AdditionalDocumentInterface;
use Project\Domains\Admin\Student\Infrastructure\Student\Services\Files\AdditionalDocument\Contracts\AdditionalDocumentServiceInterface;
use Project\Shared\Domain\File\FileSystemInterface;
use Symfony\Component\HttpFoundation\File\UploadedFile;

readonly class AdditionalDocumentService implements AdditionalDocumentServiceInterface
{
    function __construct(
        private FileSystemInterface $fileSystem
    )
    {

    }

    /**
     * @param AdditionalDocumentableInterface $additionalDocumentable
     * @param UploadedFile[] $documents
     * @return void
     */
    #[\Override]
    public function uploadDocuments(AdditionalDocumentableInterface $additionalDocumentable, array $documents): void
    {
        foreach ($documents as ['document' => $document, 'description' => $description]) {
            $this->uploadDoc($additionalDocumentable, $document, $description);
        }
    }

    #[\Override]
    public function deleteDocuments(AdditionalDocumentableInterface $additionalDocumentable): void
    {
        foreach ($additionalDocumentable->getAdditionalDocuments() as $additonalDoc) {
            // $additionalDocumentable->deleteAdditionalDocument($additonalDoc);
            $this->fileSystem->delete($additonalDoc);
        }
    }

    private function uploadDoc(AdditionalDocumentableInterface $passportable, ?UploadedFile $uploadedFile, string $description): void
    {
        if ($uploadedFile === null) {
            return;
        }

        /** @var AdditionalDocumentInterface $additionalDoc */
        $additionalDoc = $this->fileSystem->upload($passportable->getAdditionalDocumentName(), $uploadedFile);
        $additionalDoc->setDescription($description);
        $passportable->addAdditionalDocument($additionalDoc);
    }
}
