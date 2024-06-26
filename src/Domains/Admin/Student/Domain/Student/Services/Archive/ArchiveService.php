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

    public function archiveDocuments(string $archiveName, ArchivableDocumentsInterface $archivableDocuments): ArchivatorInterface
    {
        $archiveName = $this->makeArchiveName($archiveName);
        $archivator = $this->archivator->instance($archiveName);

        /**
         * @var string $fileName
         * @var File $file
         * */
        foreach (array_filter($archivableDocuments->getArchiveDocumentList()) as $fileName => $file) {
            $archivator->add(
                Storage::path($file->getFullPath()),
                sprintf('%s/%s.%s', $archiveName, $fileName, $file->getExtension())
            );
        }

        /** @var AdditionalDocument $additionalFile */
        foreach (array_filter($archivableDocuments->getArchiveAdditionalDocumentList()) as $additionalFile) {
            $archivator->add(
                Storage::path($additionalFile->getFullPath()),
                sprintf(
                    '%s/%s/%s.%s',
                    $archiveName,
                    'Additional documents',
                    $additionalFile->getDescription(),
                    $file->getExtension()
                )
            );
        }

        return $archivator;
    }

    private function makeArchiveName(string $name): string
    {
        return sprintf('%s %s', $name, date('d-m-Y H-i-s'));
    }
}
