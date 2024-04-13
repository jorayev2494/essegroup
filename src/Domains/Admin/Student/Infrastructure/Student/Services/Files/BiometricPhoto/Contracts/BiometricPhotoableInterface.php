<?php

declare(strict_types=1);

namespace Project\Domains\Admin\Student\Infrastructure\Student\Services\Files\BiometricPhoto\Contracts;

use Project\Domains\Admin\Student\Domain\Student\ValueObjects\Files\BiometricPhoto;

interface BiometricPhotoableInterface
{
    public function getBiometricPhotoClassName(): string;

    public function getBiometricPhoto(): BiometricPhoto;

    public function changeBiometricPhoto(BiometricPhotoInterface $biometricPhoto): void;

    public function deleteBiometricPhoto(): void;
}
