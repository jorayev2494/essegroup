<?php

declare(strict_types=1);

namespace Project\Domains\Admin\University\Domain\Degree;

use Project\Domains\Admin\University\Application\Degree\Queries\Index\Query;
use Project\Domains\Admin\University\Domain\Degree\ValueObjects\Uuid;
use Project\Domains\Admin\University\Infrastructure\Degree\Filters\QueryFilter;
use Project\Shared\Infrastructure\Repository\Doctrine\Paginator;

interface DegreeRepositoryInterface
{
    public function paginate(Query $httpQuery): Paginator;

    public function list(QueryFilter $filter): DegreeCollection;

    public function findByUuid(Uuid $uuid): ?Degree;

    public function findManyByUuids(Uuid ...$uuid): DegreeCollection;

    public function save(Degree $degree): void;

    public function delete(Degree $degree): void;
}
