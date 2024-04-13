<?php

declare(strict_types=1);

namespace Project\Domains\Admin\Student\Domain\Student\ValueObjects;

use Doctrine\ORM\Mapping as ORM;
use Project\Domains\Admin\Student\Domain\Student\Services\Avatar\Contracts\AvatarInterface;
use Project\Domains\Admin\Student\Domain\Student\Student;
use Project\Shared\Domain\File\File;

#[ORM\Entity]
#[ORM\Table(name: 'student_avatars')]
#[ORM\HasLifecycleCallbacks]
class Avatar extends File implements AvatarInterface
{
    #[\Override]
    public static function path(): string
    {
        return 'admin/domain/student/avatars';
    }

    #[ORM\Column(name: 'student_uuid')]
    private string $studentUuid;

    #[ORM\OneToOne(targetEntity: Student::class, inversedBy: 'avatar')]
    #[ORM\JoinColumn(name: 'student_uuid', referencedColumnName: 'uuid')]
    private ?Student $student = null;

    public function setStudent(Student $student): self
    {
        $this->student = $student;

        return $this;
    }
}
