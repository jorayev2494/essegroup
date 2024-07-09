<?php

declare(strict_types=1);

namespace Project\Domains\Admin\Student\Infrastructure\Student\Services\Files\SchoolAttestat;

use Project\Domains\Admin\Student\Infrastructure\Student\Services\Files\SchoolAttestat\Contracts\SchoolAttestateableInterface;
use Project\Domains\Admin\Student\Infrastructure\Student\Services\Files\SchoolAttestat\Contracts\SchoolAttestatServiceInterface;
use Project\Domains\Admin\University\Domain\University\ValueObjects\Logo;
use Project\Shared\Domain\File\FileSystemInterface;
use Symfony\Component\HttpFoundation\File\UploadedFile;

readonly class SchoolAttestatService implements SchoolAttestatServiceInterface
{
    function __construct(
        private FileSystemInterface $fileSystem,
    )
    {

    }

    public function upload(SchoolAttestateableInterface $passportable, ?UploadedFile $uploadedFile): void
    {
        if ($uploadedFile === null) {
            return;
        }

        /** @var Logo $passport */
        $passport = $this->fileSystem->upload($passportable->getSchoolAttestatClassName(), $uploadedFile);
        $passportable->changeSchoolAttestat($passport);
    }

    public function update(SchoolAttestateableInterface $logoable, ?UploadedFile $uploadedFile): void
    {
        if ($uploadedFile !== null) {
            $this->delete($logoable);
            $this->upload($logoable, $uploadedFile);
        }
    }

    public function delete(SchoolAttestateableInterface $logoable): void
    {
        $this->fileSystem->delete($logoable->getSchoolAttestat());
        $logoable->deleteSchoolAttestat();
    }
}
