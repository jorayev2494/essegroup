<?php

namespace Project\Domains\Admin\Student\Domain\Student\Services\Contracts;

use Project\Domains\Admin\Student\Domain\Student\Student;

interface PDFServiceInterface
{
    public function preview(Student $student): array;
}
