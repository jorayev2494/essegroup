<?php

declare(strict_types=1);

namespace Project\Domains\Admin\University\Infrastructure\Services\Media\Cover;

use Project\Domains\Admin\University\Domain\University\ValueObjects\Cover;
use Project\Domains\Admin\University\Infrastructure\Services\Media\Cover\Contracts\CoverableInterface;
use Project\Domains\Admin\University\Infrastructure\Services\Media\Cover\Contracts\CoverServiceInterface;
use Project\Shared\Domain\File\FileSystemInterface;
use Symfony\Component\HttpFoundation\File\UploadedFile;

readonly class CoverService implements CoverServiceInterface
{
    function __construct(
        private FileSystemInterface $fileSystem,
    )
    {

    }

    public function upload(CoverableInterface $coverable, ?UploadedFile $uploadedFile): void
    {
        if ($uploadedFile === null) {
            return;
        }

        /** @var Cover $logo */
        $logo = $this->fileSystem->upload(Cover::class, $uploadedFile);
        $coverable->changeCover($logo);
    }

    public function update(CoverableInterface $coverable, ?UploadedFile $uploadedFile): void
    {
        if ($uploadedFile !== null) {
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
