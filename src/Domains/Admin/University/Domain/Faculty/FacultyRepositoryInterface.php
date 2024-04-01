<?php

declare(strict_types=1);

namespace Project\Domains\Admin\University\Domain\Faculty;

use Project\Domains\Admin\University\Application\Faculty\Queries\Index\Query;
use Project\Domains\Admin\University\Domain\Faculty\ValueObjects\Uuid;
use Project\Domains\Admin\University\Infrastructure\Faculty\Filters\QueryFilter;
use Project\Shared\Infrastructure\Repository\Doctrine\Paginator;

interface FacultyRepositoryInterface
{
    public function findByUuid(Uuid $uuid): ?Faculty;

    public function paginate(Query $httpQuery): Paginator;

    public function list(QueryFilter $queryFilter): FacultyCollection;

    public function save(Faculty $university): void;

    public function delete(Faculty $university): void;
}
