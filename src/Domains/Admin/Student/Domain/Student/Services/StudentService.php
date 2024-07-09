<?php

namespace Project\Domains\Admin\Student\Domain\Student\Services;

use DateTimeImmutable;
use Project\Domains\Admin\Student\Domain\Student\Services\Contracts\StudentServiceInterface;
use Project\Domains\Admin\Student\Domain\Student\Student;
use Project\Domains\Admin\Student\Domain\Student\ValueObjects\GradeAverage;
use Project\Domains\Admin\Student\Domain\Student\ValueObjects\HighSchoolName;

class StudentService implements StudentServiceInterface
{
    public function passportInfo(Student $student, ?string $passportDateOfIssue, ?string $passportDateOfExpiry): void
    {
        if ($passportDateOfIssue !== null) {
            $student->getPassportInfo()->changeDateOfIssue(new DateTimeImmutable($passportDateOfIssue));
        }

        if ($passportDateOfExpiry !== null) {
            $student->getPassportInfo()->changeDateOfExpiry(new DateTimeImmutable($passportDateOfExpiry));
        }
    }

    public function highSchool(Student $student, ?string $highSchoolName, ?string $highSchoolGradeAverage): void
    {
        if ($highSchoolName !== null) {
            $student->getHighSchool()->setName(HighSchoolName::fromValue($highSchoolName));
        }

        if ($highSchoolGradeAverage !== null) {
            $student->getHighSchool()->setGradeAverage(GradeAverage::fromValue($highSchoolGradeAverage));
        }
    }
}
