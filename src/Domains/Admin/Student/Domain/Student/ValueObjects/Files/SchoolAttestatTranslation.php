<?php

declare(strict_types=1);

namespace Project\Domains\Admin\Student\Domain\Student\ValueObjects\Files;

use Doctrine\ORM\Mapping as ORM;
use Project\Domains\Admin\Student\Domain\Student\Student;
use Project\Domains\Admin\Student\Infrastructure\Student\Services\Files\SchoolAttestatTranslation\Contracts\SchoolAttestatTranslationInterface;
use Project\Shared\Domain\File\File;

#[ORM\Entity]
#[ORM\Table(name: 'student_student_school_attestat_translations')]
#[ORM\HasLifecycleCallbacks]
class SchoolAttestatTranslation extends File implements SchoolAttestatTranslationInterface
{
    #[\Override]
    public static function path(): string
    {
        return 'admin/domain/student/student/school_attestat_translations';
    }

    #[ORM\OneToOne(targetEntity: Student::class, mappedBy: 'schoolAttestatTranslation')]
    private Student $student;
}