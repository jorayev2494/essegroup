<?php

declare(strict_types=1);

namespace Project\Domains\Admin\Student\Domain\Student\ValueObjects\Files;

use Doctrine\ORM\Mapping as ORM;
use Project\Domains\Admin\Student\Domain\Student\Student;
use Project\Domains\Admin\Student\Infrastructure\Student\Services\Files\EquivalenceDocument\Contracts\EquivalenceDocumentInterface;
use Project\Shared\Domain\File\File;

#[ORM\Entity]
#[ORM\Table(name: 'student_student_equivalence_documents')]
#[ORM\HasLifecycleCallbacks]
class EquivalenceDocument extends File implements EquivalenceDocumentInterface
{
    #[\Override]
    public static function path(): string
    {
        return '/admin/domain/student/student/equivalence_documents';
    }

    #[ORM\OneToOne(targetEntity: Student::class, mappedBy: 'equivalenceDocument')]
    private Student $student;
}
