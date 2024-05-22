<?php

declare(strict_types=1);

namespace Project\Domains\Admin\Document\Domain\Document\Services\File\Contracts;

interface FileInterface
{
    public function getFullPath(): string;

    public function incrementDownloadedCount(): void;
}
