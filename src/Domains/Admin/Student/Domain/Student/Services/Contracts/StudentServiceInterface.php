<?php

declare(strict_types=1);

namespace Project\Domains\Admin\Student\Domain\Student\Services\Contracts;

use Project\Domains\Admin\Student\Domain\Student\Student;

interface StudentServiceInterface
{
    public function passportInfo(Student $student, ?string $passportDateOfIssue, ?string $passportDateOfExpiry): void;

    public function highSchool(Student $student, ?string $highSchoolName, ?string $highSchoolGradeAverage): void;
}
