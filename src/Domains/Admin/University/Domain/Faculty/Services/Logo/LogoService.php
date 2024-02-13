<?php

namespace Project\Domains\Admin\University\Domain\Faculty\Services\Logo;

use Project\Domains\Admin\University\Domain\Faculty\Services\Logo\Contracts\LogoServiceInterface;
use Project\Domains\Admin\University\Infrastructure\Services\Media\Logo\Contracts\LogoableInterface;
use Project\Shared\Domain\File\FileSystemInterface;
use Symfony\Component\HttpFoundation\File\UploadedFile;

readonly class LogoService implements LogoServiceInterface
{
    function __construct(
        private FileSystemInterface $fileSystem,
    )
    {

    }

    public function upload(LogoableInterface $logoable, ?UploadedFile $uploadedFile): void
    {
        if ($uploadedFile === null) {
            return;
        }

        $logo = $this->fileSystem->upload($logoable->getLogoClassName(), $uploadedFile);
        $logoable->changeLogo($logo);
    }

    public function update(LogoableInterface $logoable, ?UploadedFile $uploadedFile): void
    {
        if ($uploadedFile !== null) {
            $this->delete($logoable);
            $this->upload($logoable, $uploadedFile);
        }
    }

    public function delete(LogoableInterface $logoable): void
    {
        $this->fileSystem->delete($logoable->getLogo());
        $logoable->deleteLogo();
    }
}
