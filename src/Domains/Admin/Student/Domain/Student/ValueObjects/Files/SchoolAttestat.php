<?php

declare(strict_types=1);

namespace Project\Domains\Admin\Student\Domain\Student\ValueObjects\Files;

use Doctrine\ORM\Mapping as ORM;
use Project\Domains\Admin\Student\Domain\Student\Student;
use Project\Domains\Admin\Student\Infrastructure\Student\Services\Files\SchoolAttestat\Contracts\SchoolAttestatInterface;
use Project\Shared\Domain\File\File;

#[ORM\Entity]
#[ORM\Table(name: 'student_student_school_attestats')]
#[ORM\HasLifecycleCallbacks]
class SchoolAttestat extends File implements SchoolAttestatInterface
{
    #[\Override]
    public static function path(): string
    {
        return 'admin/domain/student/student/school_attestats';
    }

    #[ORM\OneToOne(targetEntity: Student::class, mappedBy: 'schoolAttestat')]
    private Student $student;
}
