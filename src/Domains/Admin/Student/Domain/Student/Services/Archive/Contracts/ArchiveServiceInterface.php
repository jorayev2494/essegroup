<?php

namespace Project\Domains\Admin\Student\Domain\Student\Services\Archive\Contracts;

use Project\Infrastructure\Archivator\Contracts\ArchivatorInterface;

interface ArchiveServiceInterface
{
    public function archiveDocuments(string $archiveName, ArchivableDocumentsInterface $archivableDocuments): ArchivatorInterface;
}
