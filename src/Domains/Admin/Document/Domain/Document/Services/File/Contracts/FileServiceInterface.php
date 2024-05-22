<?php

declare(strict_types=1);

namespace Project\Domains\Admin\Document\Domain\Document\Services\File\Contracts;

use Project\Domains\Admin\Document\Domain\Document\ValueObjects\File;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\StreamedResponse;

interface FileServiceInterface
{
    public function upload(FileableInterface $fileable, ?UploadedFile $uploadedFile): void;

    public function update(FileableInterface $fileable, ?UploadedFile $uploadedFile): void;

    public function download(File $file, ?string $name = null, array $headers = []): StreamedResponse;

    public function delete(FileableInterface $fileable): void;
}
