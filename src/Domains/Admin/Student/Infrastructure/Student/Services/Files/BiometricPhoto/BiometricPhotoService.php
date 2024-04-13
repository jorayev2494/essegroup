<?php

declare(strict_types=1);

namespace Project\Domains\Admin\Student\Infrastructure\Student\Services\Files\BiometricPhoto;

use Project\Domains\Admin\Student\Infrastructure\Student\Services\Files\BiometricPhoto\Contracts\BiometricPhotoableInterface;
use Project\Domains\Admin\Student\Infrastructure\Student\Services\Files\BiometricPhoto\Contracts\BiometricPhotoInterface;
use Project\Domains\Admin\Student\Infrastructure\Student\Services\Files\BiometricPhoto\Contracts\BiometricPhotoServiceInterface;
use Project\Shared\Domain\File\FileSystemInterface;
use Symfony\Component\HttpFoundation\File\UploadedFile;

readonly class BiometricPhotoService implements BiometricPhotoServiceInterface
{
    function __construct(
        private FileSystemInterface $fileSystem,
    )
    {

    }

    public function upload(BiometricPhotoableInterface $biometricPhotoable, ?UploadedFile $uploadedFile): void
    {
        if ($uploadedFile === null) {
            return;
        }


        /** @var BiometricPhotoInterface $biometricPhoto */
        $biometricPhoto = $this->fileSystem->upload($biometricPhotoable->getBiometricPhotoClassName(), $uploadedFile);
        $biometricPhotoable->changeBiometricPhoto($biometricPhoto);
        // dd($biometricPhotoable, $biometricPhoto);
    }

    public function update(BiometricPhotoableInterface $biometricPhotoable, ?UploadedFile $uploadedFile): void
    {
        if ($uploadedFile !== null) {
            $this->delete($biometricPhotoable);
            $this->upload($biometricPhotoable, $uploadedFile);
        }
    }

    public function delete(BiometricPhotoableInterface $biometricPhotoable): void
    {
        $this->fileSystem->delete($biometricPhotoable->getBiometricPhoto());
        $biometricPhotoable->deleteBiometricPhoto();
    }
}
