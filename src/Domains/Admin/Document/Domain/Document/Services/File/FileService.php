<?php

declare(strict_types=1);

namespace Project\Domains\Admin\Document\Domain\Document\Services\File;

use Project\Domains\Admin\Document\Domain\Document\Services\File\Contracts\FileableInterface;
use Project\Domains\Admin\Document\Domain\Document\Services\File\Contracts\FileServiceInterface;
use Project\Domains\Admin\Document\Domain\Document\ValueObjects\File;
use Project\Shared\Domain\File\FileSystemInterface;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\StreamedResponse;

readonly class FileService implements FileServiceInterface
{
    function __construct(
        private FileSystemInterface $fileSystem
    ) { }

    public function upload(FileableInterface $fileable, ?UploadedFile $uploadedFile): void
    {
        if ($uploadedFile === null) {
            return;
        }

        /** @var File $cover */
        $cover = $this->fileSystem->upload(File::class, $uploadedFile);
        $fileable->changeFile($cover);
    }

    public function update(FileableInterface $fileable, ?UploadedFile $uploadedFile): void
    {
        if ($uploadedFile instanceof UploadedFile) {
            $this->delete($fileable);
            $this->upload($fileable, $uploadedFile);
        }
    }

    public function download(File $file, ?string $name = null, array $headers = []): StreamedResponse
    {
        return $this->fileSystem->download($file, $name, $headers);
    }

    public function delete(FileableInterface $fileable): void
    {
        $this->fileSystem->delete($fileable->getFile());
        $fileable->deleteFile();
    }
}
