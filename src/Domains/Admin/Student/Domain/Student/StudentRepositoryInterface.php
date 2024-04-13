<?php

declare(strict_types=1);

namespace Project\Domains\Admin\Student\Domain\Student;

use Project\Domains\Admin\Student\Application\Queries\Index\Query;
use Project\Domains\Admin\Student\Domain\Student\ValueObjects\Uuid;
use Project\Shared\Infrastructure\Repository\Doctrine\Paginator;

interface StudentRepositoryInterface
{
    public function paginate(Query $httpQuery): ?Paginator;

    public function findByUuid(Uuid $uuid): ?Student;

    public function save(Student $student): void;

    public function delete(Student $student): void;
}
