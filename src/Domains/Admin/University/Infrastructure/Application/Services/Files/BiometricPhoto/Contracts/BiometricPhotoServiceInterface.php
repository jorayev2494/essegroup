<?php

declare(strict_types=1);

namespace Project\Domains\Admin\University\Infrastructure\Application\Services\Files\BiometricPhoto\Contracts;

use Symfony\Component\HttpFoundation\File\UploadedFile;

interface BiometricPhotoServiceInterface
{
    public function upload(BiometricPhotoableInterface $biometricPhotoable, ?UploadedFile $uploadedFile): void;

    public function update(BiometricPhotoableInterface $biometricPhotoable, ?UploadedFile $uploadedFile): void;

    public function delete(BiometricPhotoableInterface $biometricPhotoable): void;
}
