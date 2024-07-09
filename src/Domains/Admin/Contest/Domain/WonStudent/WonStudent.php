<?php

declare(strict_types=1);

namespace Project\Domains\Admin\Contest\Domain\WonStudent;

use DateTimeImmutable;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Project\Domains\Admin\Contest\Domain\Contest\Contest;
use Project\Domains\Admin\Contest\Domain\Contest\ContestTranslate;
use Project\Domains\Admin\Contest\Domain\WonStudent\ValueObjects\Code;
use Project\Domains\Admin\Contest\Domain\WonStudent\ValueObjects\Note;
use Project\Domains\Admin\Contest\Infrastructure\WinnerStudent\Repositories\Doctrine\Types\CodeType;
use Project\Domains\Admin\Contest\Infrastructure\WinnerStudent\Repositories\Doctrine\Types\NoteType;
use Project\Domains\Admin\Student\Domain\Student\Student;
use Project\Shared\Contracts\ArrayableInterface;
use Project\Shared\Domain\Traits\ActivableTrait;
use Project\Shared\Domain\Traits\CreatedAtAndUpdatedAtTrait;

#[ORM\Entity]
#[ORM\Table(name: 'contest_won_students', options: ['auto_increment' => 100000])]
#[ORM\HasLifecycleCallbacks]
class WonStudent implements ArrayableInterface
{
    use ActivableTrait,
        CreatedAtAndUpdatedAtTrait;

    #[ORM\Id]
    #[ORM\GeneratedValue(strategy: 'AUTO')]
    #[ORM\Column(type: CodeType::NAME)]
    private Code $code;

    #[ORM\Column(name: 'contest_uuid', type: Types::GUID, nullable: true)]
    private ?string $contestUuid;

    #[ORM\ManyToOne(targetEntity: Contest::class, cascade: ['persist'], inversedBy: 'wonStudents')]
    #[ORM\JoinColumn(name: 'contest_uuid', referencedColumnName: 'uuid', onDelete: 'CASCADE')]
    private Contest $contest;

    #[ORM\Column(name: 'student_uuid', type: Types::GUID, nullable: true)]
    private ?string $studentUuid;

    #[ORM\ManyToOne(targetEntity: Student::class, cascade: ['persist'], inversedBy: 'wonContests')]
    #[ORM\JoinColumn(name: 'student_uuid', referencedColumnName: 'uuid', onDelete: 'SET NULL')]
    private Student $student;

    #[ORM\Column(name: 'gift_given_at', type: Types::DATETIME_IMMUTABLE, nullable: true)]
    private ?DateTimeImmutable $giftGivenAt;

    #[ORM\Column(type: NoteType::NAME, nullable: true)]
    private Note $note;

    private function __construct(Contest $contest, Student $student)
    {
        $this->contest = $contest;
        $this->student = $student;
        $this->giftGivenAt = null;
        $this->isActive = true;
    }

    public static function create(Contest $contest, Student $student): self
    {
        return new self($contest, $student);
    }

    public function getCode(): Code
    {
        return $this->code;
    }

    public function changeGiftGivenAt(?DateTimeImmutable $giftGivenAt): self
    {
        if ($this->giftGivenAt?->getTimestamp() !== $giftGivenAt?->getTimestamp()) {
            $this->giftGivenAt = $giftGivenAt;
        }

        return $this;
    }

    public function changeNote(Note $note): self
    {
        if ($this->note->isNotEquals($note)) {
            $this->note = $note;
        }

        return $this;
    }

    public function getStudent(): Student
    {
        return $this->student;
    }

    public function toArray(): array
    {
        return [
            'code' => $this->code->value,
            'contest_uuid' => $this->contestUuid,
            'contest' => [
                'uuid' => $this->contest->getUuid()->value,
                'title' => ContestTranslate::execute($this->contest)->getTitle()->value,
            ],
            'student_code' => $this->studentUuid,
            'student' => [
                'uuid' => $this->student->getUuid()->value,
                'avatar' => $this->student->getAvatar()?->toArray(),
                ...$this->student->getFullName()->toArray(),
                // 'company' => $this->student->getCompany()?->toArray(),
            ],
            'gift_given_at' => $this->giftGivenAt?->getTimestamp(),
            'note' => $this->note->value,
            'created_at' => $this->createdAt->getTimestamp(),
            'updated_at' => $this->updatedAt->getTimestamp(),
        ];
    }
}
