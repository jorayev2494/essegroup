<?php

declare(strict_types=1);

namespace Project\Domains\Admin\Student\Domain\Student\ValueObjects\Files;

use Doctrine\ORM\Mapping as ORM;
use Project\Domains\Admin\Student\Domain\Student\Student;
use Project\Domains\Admin\Student\Infrastructure\Student\Services\Files\BiometricPhoto\Contracts\BiometricPhotoInterface;
use Project\Shared\Domain\File\File;

#[ORM\Entity]
#[ORM\Table(name: 'student_student_biometric_photos')]
#[ORM\HasLifecycleCallbacks]
class BiometricPhoto extends File implements BiometricPhotoInterface
{
    #[\Override]
    public static function path(): string
    {
        return 'admin/domain/student/student/biometric_photos';
    }

    #[ORM\OneToOne(targetEntity: Student::class, mappedBy: 'biometricPhoto')]
    private Student $student;
}
