<?php

declare(strict_types=1);

namespace Project\Domains\Admin\University\Domain\University;

use Project\Domains\Admin\University\Application\University\Queries\Index\Query;
use Project\Domains\Admin\University\Domain\University\ValueObjects\Uuid;
use Project\Domains\Admin\University\Infrastructure\University\Filters\HttpQueryFilterDTO;
use Project\Shared\Domain\Bus\Query\BaseHttpQueryParams;
use Project\Shared\Infrastructure\Repository\Doctrine\Paginator;

interface UniversityRepositoryInterface
{
    public function get(): UniversityCollection;

    public function paginate(Query $baseHttpQueryParams): Paginator;

    public function list(HttpQueryFilterDTO $httpQueryFilterDTO): UniversityCollection;

    public function findByUuid(Uuid $uuid): ?University;

    public function save(University $university): void;

    public function delete(University $university): void;
}
