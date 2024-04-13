<?php

declare(strict_types=1);

namespace Project\Domains\Admin\Student\Domain\Student\ValueObjects\Files;

use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Project\Domains\Admin\Student\Domain\Student\Student;
use Project\Domains\Admin\Student\Infrastructure\Student\Services\Files\AdditionalDocument\Contracts\AdditionalDocumentInterface;
use Project\Shared\Domain\File\File;

#[ORM\Entity]
#[ORM\Table(name: 'student_student_additional_documents')]
#[ORM\HasLifecycleCallbacks]
class AdditionalDocument extends File implements AdditionalDocumentInterface
{
    #[\Override]
    public static function path(): string
    {
        return 'admin/domain/student/student/additional_documents';
    }

    #[ORM\Column(type: Types::STRING)]
    private ?string $description = null;

    #[ORM\ManyToOne(targetEntity: Student::class, inversedBy: 'additionalDocuments')]
    #[ORM\JoinColumn(name: 'student_uuid', referencedColumnName: 'uuid')]
    private Student $student;

    public function setStudent(?Student $student): void
    {
        $this->student = $student;
    }

    public function setDescription(string $description): void
    {
        if ($this->description !== $description) {
            $this->description = $description;
        }
    }

    public function toArray(): array
    {
        return array_merge(
            parent::toArray(),
            ['description' => $this->description]
        );
    }
}
