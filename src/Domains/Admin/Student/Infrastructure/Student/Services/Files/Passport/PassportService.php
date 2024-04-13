<?php

declare(strict_types=1);

namespace Project\Domains\Admin\Student\Infrastructure\Student\Services\Files\Passport;

use Project\Domains\Admin\Student\Infrastructure\Student\Services\Files\Passport\Contracts\PassportableInterface;
use Project\Domains\Admin\Student\Infrastructure\Student\Services\Files\Passport\Contracts\PassportServiceInterface;
use Project\Domains\Admin\University\Domain\University\ValueObjects\Logo;
use Project\Shared\Domain\File\FileSystemInterface;
use Symfony\Component\HttpFoundation\File\UploadedFile;

readonly class PassportService implements PassportServiceInterface
{
    function __construct(
        private FileSystemInterface $fileSystem,
    )
    {

    }

    public function upload(PassportableInterface $passportable, ?UploadedFile $uploadedFile): void
    {
        if ($uploadedFile === null) {
            return;
        }

        /** @var Logo $passport */
        $passport = $this->fileSystem->upload($passportable->getPassportClassName(), $uploadedFile);
        $passportable->changePassport($passport);
    }

    public function update(PassportableInterface $logoable, ?UploadedFile $uploadedFile): void
    {
        if ($uploadedFile !== null) {
            $this->delete($logoable);
            $this->upload($logoable, $uploadedFile);
        }
    }

    public function delete(PassportableInterface $logoable): void
    {
        $this->fileSystem->delete($logoable->getPassport());
        $logoable->deletePassport();
    }
}
