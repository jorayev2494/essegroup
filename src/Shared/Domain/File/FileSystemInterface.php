<?php

declare(strict_types=1);

namespace Project\Shared\Domain\File;


use Symfony\Component\HttpFoundation\File\UploadedFile;

interface FileSystemInterface
{
    public function upload(string $className, UploadedFile $uploadedFile): File;

    public function delete(?File $file): bool;
}
