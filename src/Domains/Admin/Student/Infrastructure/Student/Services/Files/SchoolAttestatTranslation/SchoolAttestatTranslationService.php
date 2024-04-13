<?php

declare(strict_types=1);

namespace Project\Domains\Admin\Student\Infrastructure\Student\Services\Files\SchoolAttestatTranslation;

use Project\Domains\Admin\Student\Domain\Student\ValueObjects\Files\SchoolAttestatTranslation;
use Project\Domains\Admin\Student\Infrastructure\Student\Services\Files\SchoolAttestatTranslation\Contracts\SchoolAttestatTranslationableInterface;
use Project\Domains\Admin\Student\Infrastructure\Student\Services\Files\SchoolAttestatTranslation\Contracts\SchoolAttestatTranslationServiceInterface;
use Project\Shared\Domain\File\FileSystemInterface;
use Symfony\Component\HttpFoundation\File\UploadedFile;

readonly class SchoolAttestatTranslationService implements SchoolAttestatTranslationServiceInterface
{
    function __construct(
        private FileSystemInterface $fileSystem,
    )
    {

    }

    public function upload(SchoolAttestatTranslationableInterface $schoolAttestatTranslationable, ?UploadedFile $uploadedFile): void
    {
        if ($uploadedFile === null) {
            return;
        }

        /** @var SchoolAttestatTranslation $schoolAttestatTranslation */
        $schoolAttestatTranslation = $this->fileSystem->upload($schoolAttestatTranslationable->getSchoolAttestatTranslationClassName(), $uploadedFile);
        $schoolAttestatTranslationable->changeSchoolAttestatTranslation($schoolAttestatTranslation);
    }

    public function update(SchoolAttestatTranslationableInterface $schoolAttestatTranslationable, ?UploadedFile $uploadedFile): void
    {
        if ($uploadedFile !== null) {
            $this->delete($schoolAttestatTranslationable);
            $this->upload($schoolAttestatTranslationable, $uploadedFile);
        }
    }

    public function delete(SchoolAttestatTranslationableInterface $schoolAttestatTranslationable): void
    {
        $this->fileSystem->delete($schoolAttestatTranslationable->getSchoolAttestatTranslation());
        $schoolAttestatTranslationable->deleteSchoolAttestatTranslation();
    }
}
