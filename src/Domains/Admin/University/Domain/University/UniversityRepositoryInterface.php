<?php

declare(strict_types=1);

namespace Project\Domains\Admin\University\Domain\University;

use Project\Domains\Admin\University\Application\University\Queries\Index\Query;
use Project\Domains\Admin\University\Domain\University\ValueObjects\Uuid;
use Project\Domains\Admin\University\Infrastructure\University\Filters\QueryFilter;
use Project\Shared\Infrastructure\Repository\Doctrine\Paginator;

interface UniversityRepositoryInterface
{
    public function get(): UniversityCollection;

    public function paginate(Query $httpQuery): Paginator;

    public function list(QueryFilter $httpQueryFilterDTO): UniversityCollection;

    public function findByUuid(Uuid $uuid): ?University;

    public function findManyByCompanyUuid(string $companyUuid): UniversityCollection;

    public function save(University $university): void;

    public function delete(University $university): void;
}
