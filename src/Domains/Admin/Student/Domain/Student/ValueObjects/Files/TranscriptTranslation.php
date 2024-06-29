<?php

declare(strict_types=1);

namespace Project\Domains\Admin\Student\Domain\Student\ValueObjects\Files;

use Doctrine\ORM\Mapping as ORM;
use Project\Domains\Admin\Student\Domain\Student\Student;
use Project\Domains\Admin\Student\Infrastructure\Student\Services\Files\TranscriptTranslation\Contracts\TranscriptTranslationInterface;
use Project\Shared\Domain\File\File;

#[ORM\Entity]
#[ORM\Table(name: 'student_student_transcript_translations')]
#[ORM\HasLifecycleCallbacks]
class TranscriptTranslation extends File implements TranscriptTranslationInterface
{
    #[\Override]
    public static function path(): string
    {
        return '/admin/domain/student/student/transcript_translations';
    }

    #[ORM\OneToOne(targetEntity: Student::class, mappedBy: 'transcriptTranslation')]
    private Student $student;
}
