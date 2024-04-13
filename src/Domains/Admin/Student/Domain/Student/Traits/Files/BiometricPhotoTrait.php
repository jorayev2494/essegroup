<?php

declare(strict_types=1);

namespace Project\Domains\Admin\Student\Domain\Student\Traits\Files;

use Doctrine\ORM\Mapping as ORM;
use Project\Domains\Admin\Student\Domain\Student\ValueObjects\Files\BiometricPhoto;
use Project\Domains\Admin\Student\Infrastructure\Student\Services\Files\BiometricPhoto\Contracts\BiometricPhotoInterface;

trait BiometricPhotoTrait
{
    #[ORM\ManyToOne(targetEntity: BiometricPhoto::class, cascade: ['persist', 'remove'], inversedBy: 'application')]
    #[ORM\JoinColumn(name: 'biometric_photo_uuid', referencedColumnName: 'uuid', nullable: false)]
    private BiometricPhoto $biometricPhoto;

    #[\Override]
    public function getBiometricPhotoClassName(): string
    {
        return BiometricPhoto::class;
    }

    #[\Override]
    public function getBiometricPhoto(): BiometricPhoto
    {
        return $this->biometricPhoto;
    }

    #[\Override]
    public function changeBiometricPhoto(BiometricPhotoInterface $biometricPhoto): void
    {
        $this->biometricPhoto = $biometricPhoto;
    }

    #[\Override]
    public function deleteBiometricPhoto(): void
    {
        // TODO: Implement deleteBiometricPhoto() method.
    }
}
