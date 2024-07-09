<?php

declare(strict_types=1);

namespace Project\Domains\Admin\University\Domain\University;

use Project\Domains\Admin\University\Application\University\Queries\Index\Query as IndexQuery;
use Project\Domains\Admin\University\Domain\University\ValueObjects\Uuid;
use Project\Domains\Admin\University\Infrastructure\University\Filters\QueryFilter;
use Project\Shared\Infrastructure\Filters\BaseSearch;
use Project\Shared\Infrastructure\Repository\Doctrine\Paginator;
use Project\Shared\Infrastructure\Repository\Doctrine\PaginatorHttpQueryParams;
use Project\Domains\Admin\University\Application\University\Queries\List\Query as ListQuery;

interface UniversityRepositoryInterface
{
    public function get(): UniversityCollection;

    public function paginate(IndexQuery $httpQuery): Paginator;

    public function list(ListQuery $httpQuery): UniversityCollection;

    public function search(PaginatorHttpQueryParams $queryParams, BaseSearch $search, QueryFilter $queryFilter): Paginator;

    public function findByUuid(Uuid $uuid): ?University;

    public function save(University $university): void;

    public function delete(University $university): void;
}
