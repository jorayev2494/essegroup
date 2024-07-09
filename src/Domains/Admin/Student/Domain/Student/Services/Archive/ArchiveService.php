<?php

declare(strict_types=1);

namespace Project\Domains\Admin\Student\Domain\Student\Services\Archive;

use Illuminate\Support\Facades\Storage;
use Project\Domains\Admin\Student\Domain\Student\Services\Archive\Contracts\ArchivableDocumentsInterface;
use Project\Domains\Admin\Student\Domain\Student\Services\Archive\Contracts\ArchiveServiceInterface;
use Project\Domains\Admin\Student\Domain\Student\ValueObjects\Files\AdditionalDocument;
use Project\Infrastructure\Archivator\Contracts\ArchivatorInterface;
use Project\Shared\Domain\File\File;

class ArchiveService implements ArchiveServiceInterface
{
    public function __construct(
        private ArchivatorInterface $archivator
    ) { }

    public function archiveDocuments(ArchivableDocumentsInterface $archivableDocuments, string $archiveName): ArchivatorInterface
    {
        $archiveName = $this->makeArchiveName($archiveName);
        $this->archivator = $this->archivator->instance($archiveName);

        $this->archiveDocumentList($archivableDocuments->getArchiveDocumentList(), $archiveName);
        $this->archiveAdditionalDocumentsList($archivableDocuments->getArchiveAdditionalDocumentList(), $archiveName);

        return $this->archivator;
    }

    private function archiveDocumentList(array $documents, string $archiveName): void
    {
        /**
         * @var string $fileName
         * @var File $file
         * */
        foreach (array_filter($documents) as $fileName => $file) {
            $this->archivator->add(
                $file->getFullPath(),
                sprintf('%s/%s.%s', $archiveName, $fileName, $file->getExtension())
            );
        }
    }

    private function archiveAdditionalDocumentsList(array $additionalDocuments, string $archiveName): void
    {
        /**
         * @var AdditionalDocument $additionalFile
         */
        foreach (array_filter($additionalDocuments) as $additionalFile) {
            $this->archivator->add(
                $additionalFile->getFullPath(),
                sprintf(
                    '%s/%s/%s.%s',
                    $archiveName,
                    'Additional documents',
                    $additionalFile->getDescription(),
                    $additionalFile->getExtension()
                )
            );
        }
    }

    private function makeArchiveName(string $name): string
    {
        return sprintf('%s %s', $name, date('d-m-Y H-i-s'));
    }
}
