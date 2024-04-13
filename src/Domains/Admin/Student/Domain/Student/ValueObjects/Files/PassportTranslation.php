<?php

declare(strict_types=1);

namespace Project\Domains\Admin\Student\Domain\Student\ValueObjects\Files;

use Doctrine\ORM\Mapping as ORM;
use Project\Domains\Admin\Student\Domain\Student\Student;
use Project\Domains\Admin\Student\Infrastructure\Student\Services\Files\PassportTranslation\Contracts\PassportTranslationInterface;
use Project\Shared\Domain\File\File;

#[ORM\Entity]
#[ORM\Table(name: 'student_student_passport_translations')]
#[ORM\HasLifecycleCallbacks]
class PassportTranslation extends File implements PassportTranslationInterface
{
    #[\Override]
    public static function path(): string
    {
        return 'admin/domain/student/student/passport_translations';
    }

    #[ORM\OneToOne(targetEntity: Student::class, mappedBy: 'passportTranslation')]
    private Student $student;
}
