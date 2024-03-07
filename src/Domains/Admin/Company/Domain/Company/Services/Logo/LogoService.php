<?php

declare(strict_types=1);

namespace Project\Domains\Admin\Company\Domain\Company\Services\Logo;

use Project\Domains\Admin\Company\Domain\Company\Company;
use Project\Domains\Admin\Company\Domain\Company\Services\Logo\Contracts\LogoableInterface;
use Project\Domains\Admin\Company\Domain\Company\Services\Logo\Contracts\LogoInterface;
use Project\Domains\Admin\Company\Domain\Company\Services\Logo\Contracts\LogoServiceInterface;
use Project\Domains\Admin\Company\Domain\Company\ValueObjects\Logo;
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

        /** @var Logo $logo */
        $logo = $this->fileSystem->upload(Logo::class, $uploadedFile);
        $logoable->changeLogo($logo);
    }

    public function update(LogoableInterface $logoable, ?UploadedFile $uploadedFile): void
    {
        if ($uploadedFile instanceof UploadedFile) {
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
