<?php

declare(strict_types=1);

namespace Project\Domains\Admin\University\Domain\Application\ValueObjects;

use Doctrine\ORM\Mapping as ORM;
use Project\Domains\Admin\University\Domain\Application\Application;
use Project\Domains\Admin\University\Infrastructure\Application\Services\Files\BiometricPhoto\Contracts\BiometricPhotoInterface;
use Project\Domains\Admin\University\Infrastructure\Application\Services\Files\Passport\Contracts\PassportInterface;
use Project\Shared\Domain\File\File;

#[ORM\Entity]
#[ORM\Table('university_application_biometric_photos')]
#[ORM\HasLifecycleCallbacks]
class BiometricPhoto extends File implements BiometricPhotoInterface
{
    #[\Override]
    public static function path(): string
    {
        return 'admin/domain/university/application/biometric_photos';
    }

    #[ORM\OneToOne(targetEntity: Application::class, mappedBy: 'biometricPhoto')]
    private Application $application;
}
