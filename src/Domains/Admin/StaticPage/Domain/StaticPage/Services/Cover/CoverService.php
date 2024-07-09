<?php

declare(strict_types=1);

namespace Project\Domains\Admin\StaticPage\Domain\StaticPage\Services\Cover;

use Project\Domains\Admin\StaticPage\Domain\StaticPage\Services\Cover\Contracts\CoverableInterface;
use Project\Domains\Admin\StaticPage\Domain\StaticPage\Services\Cover\Contracts\CoverServiceInterface;
use Project\Domains\Admin\StaticPage\Domain\StaticPage\ValueObjects\Cover;
use Project\Shared\Domain\File\FileSystemInterface;
use Symfony\Component\HttpFoundation\File\UploadedFile;

readonly class CoverService implements CoverServiceInterface
{
    function __construct(
        private FileSystemInterface $fileSystem
    ) { }

    public function upload(CoverableInterface $coverable, ?UploadedFile $uploadedFile): void
    {
        if ($uploadedFile === null) {
            return;
        }

        /** @var Cover $cover */
        $cover = $this->fileSystem->upload(Cover::class, $uploadedFile);
        $coverable->changeCover($cover);
    }

    public function update(CoverableInterface $coverable, ?UploadedFile $uploadedFile): void
    {
        if ($uploadedFile instanceof UploadedFile) {
            $this->delete($coverable);
            $this->upload($coverable, $uploadedFile);
        }
    }

    public function delete(CoverableInterface $coverable): void
    {
        $this->fileSystem->delete($coverable->getCover());
        $coverable->deleteCover();
    }
}
