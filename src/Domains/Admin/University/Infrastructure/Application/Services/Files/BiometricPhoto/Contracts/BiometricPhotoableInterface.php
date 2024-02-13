<?php

declare(strict_types=1);

namespace Project\Domains\Admin\University\Infrastructure\Application\Services\Files\BiometricPhoto\Contracts;

use Project\Domains\Admin\University\Domain\Application\ValueObjects\BiometricPhoto;

interface BiometricPhotoableInterface
{
    public function getBiometricPhotoClassName(): string;

    public function getBiometricPhoto(): BiometricPhoto;

    public function changeBiometricPhoto(BiometricPhotoInterface $biometricPhoto): void;

    public function deleteBiometricPhoto(): void;
}
