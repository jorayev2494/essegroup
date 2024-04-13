<?php

declare(strict_types=1);

namespace Project\Domains\Admin\Student\Domain\Student\ValueObjects\Files;

use Doctrine\ORM\Mapping as ORM;
use Project\Domains\Admin\Student\Domain\Student\Student;
use Project\Domains\Admin\Student\Infrastructure\Student\Services\Files\Passport\Contracts\PassportInterface;
use Project\Shared\Domain\File\File;

#[ORM\Entity]
#[ORM\Table(name: 'student_student_passports')]
#[ORM\HasLifecycleCallbacks]
class Passport extends File implements PassportInterface
{
    #[\Override]
    public static function path(): string
    {
        return 'admin/domain/student/student/passports';
    }

    #[ORM\OneToOne(targetEntity: Student::class, mappedBy: 'passport')]
    private Student $student;
}
