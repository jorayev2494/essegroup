<?php

namespace Project\Domains\Admin\Student\Domain\Student\Services\Archive\Contracts;

interface ArchivableDocumentsInterface
{
    public function getArchiveDocumentList(): array;

    public function getArchiveAdditionalDocumentList(): array;
}
