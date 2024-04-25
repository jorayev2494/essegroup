<?php

declare(strict_types=1);

namespace Project\Domains\Admin\Company\Domain\Employee;

use Project\Domains\Admin\Company\Application\Employee\Queries\Index\Query;
use Project\Domains\Admin\Company\Domain\Employee\ValueObjects\Email;
use Project\Domains\Admin\Company\Domain\Employee\ValueObjects\Uuid;
use Project\Shared\Infrastructure\Repository\Doctrine\Paginator;

interface EmployeeRepositoryInterface
{
    public function findByUuid(Uuid $uuid): ?Employee;

    public function findByEmail(Email $email): ?Employee;

    public function paginate(Query $httpQuery): Paginator;

    public function save(Employee $employee): void;

    public function delete(Employee $employee): void;
}
