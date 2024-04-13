<?php

declare(strict_types=1);

namespace Project\Domains\Admin\Student\Domain\Student\ValueObjects\Embeddables;

use Doctrine\ORM\Mapping as ORM;
use Project\Domains\Admin\Student\Domain\Student\ValueObjects\GradeAverage;
use Project\Domains\Admin\Student\Domain\Student\ValueObjects\HighSchoolName;
use Project\Domains\Admin\Student\Infrastructure\Student\Repositories\Doctrine\Types\GradeAverageType;
use Project\Domains\Admin\Student\Infrastructure\Student\Repositories\Doctrine\Types\HighSchoolNameType;
use Project\Shared\Contracts\ArrayableInterface;

#[ORM\Embeddable]
class HighSchool implements ArrayableInterface
{

    #[ORM\Column(name: 'name', type: HighSchoolNameType::NAME)]
    private HighSchoolName $name;

    #[ORM\Column(name: 'grade_average', type: GradeAverageType::NAME, length: 5, nullable: true)]
    private GradeAverage $gradeAverage;

    public function __construct(HighSchoolName $name, GradeAverage $gradeAverage)
    {
        $this->name = $name;
        $this->gradeAverage = $gradeAverage;
    }

    public static function make(HighSchoolName $name, GradeAverage $gradeAverage): self
    {
        return new self($name, $gradeAverage);
    }

    public function getName(): HighSchoolName
    {
        return $this->name;
    }

    public function getGradeAverage(): GradeAverage
    {
        return $this->gradeAverage;
    }

    public function isEquals(self $other): bool
    {
        return $this->name->isEquals($other->getName())
            || $this->gradeAverage->isEquals($other->getGradeAverage());
    }

    public function isNotEquals(self $other): bool
    {
        return $this->name->isNotEquals($other->getName())
            || $this->gradeAverage->isEquals($other->getGradeAverage());
    }

    public function toArray(): array
    {
        return [
            'high_school_name' => $this->name->value,
            'high_school_grade_average' => $this->gradeAverage->value,
        ];
    }
}
