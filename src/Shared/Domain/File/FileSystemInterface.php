<?php

declare(strict_types=1);

namespace Project\Shared\Domain\File;


use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\StreamedResponse;

interface FileSystemInterface
{
    public function upload(string $className, UploadedFile $uploadedFile): File;

    public function download(File $file, ?string $name = null, array $headers = []): StreamedResponse;

    public function delete(?File $file): bool;
}
