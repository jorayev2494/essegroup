<?php

declare(strict_types=1);

namespace Project\Domains\Admin\Student\Domain\Student\ValueObjects\Files;

use Doctrine\ORM\Mapping as ORM;
use Project\Domains\Admin\Student\Domain\Student\Student;
use Project\Domains\Admin\Student\Infrastructure\Student\Services\Files\Transcript\Contracts\TranscriptInterface;
use Project\Shared\Domain\File\File;

#[ORM\Entity]
#[ORM\Table(name: 'student_student_transcripts')]
#[ORM\HasLifecycleCallbacks]
class Transcript extends File implements TranscriptInterface
{
    #[\Override]
    public static function path(): string
    {
        return 'admin/domain/student/student/transcripts';
    }

    #[ORM\OneToOne(targetEntity: Student::class, mappedBy: 'transcript')]
    private Student $student;
}
