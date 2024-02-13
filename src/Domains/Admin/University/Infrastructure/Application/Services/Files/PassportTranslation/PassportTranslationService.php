<?php

declare(strict_types=1);

namespace Project\Domains\Admin\University\Infrastructure\Application\Services\Files\PassportTranslation;

use Project\Domains\Admin\University\Domain\University\ValueObjects\Logo;
use Project\Domains\Admin\University\Infrastructure\Application\Services\Files\PassportTranslation\Contracts\PassportTranslationableInterface;
use Project\Domains\Admin\University\Infrastructure\Application\Services\Files\PassportTranslation\Contracts\PassportTranslationServiceInterface;
use Project\Shared\Domain\File\FileSystemInterface;
use Symfony\Component\HttpFoundation\File\UploadedFile;

readonly class PassportTranslationService implements PassportTranslationServiceInterface
{
    function __construct(
        private FileSystemInterface $fileSystem,
    )
    {

    }

    public function upload(PassportTranslationableInterface $passportTranslationable, ?UploadedFile $uploadedFile): void
    {
        if ($uploadedFile === null) {
            return;
        }

        /** @var Logo $passport */
        $passport = $this->fileSystem->upload($passportTranslationable->getPassportTranslationClassName(), $uploadedFile);
        $passportTranslationable->changePassportTranslation($passport);
    }

    public function update(PassportTranslationableInterface $passportTranslationable, ?UploadedFile $uploadedFile): void
    {
        if ($uploadedFile !== null) {
            $this->delete($passportTranslationable);
            $this->upload($passportTranslationable, $uploadedFile);
        }
    }

    public function delete(PassportTranslationableInterface $passportTranslationable): void
    {
        $this->fileSystem->delete($passportTranslationable->getPassportTranslation());
        $passportTranslationable->deletePassportTranslation();
    }
}
