<?php

declare(strict_types=1);

namespace Project\Domains\Admin\University\Domain\Faculty;

use Project\Domains\Admin\University\Domain\Faculty\ValueObjects\Uuid;
use Project\Domains\Admin\University\Infrastructure\Faculty\Filters\HttpQueryFilterDTO;
use Project\Shared\Domain\Bus\Query\BaseHttpQueryParams;
use Project\Shared\Infrastructure\Repository\Doctrine\Paginator;

interface FacultyRepositoryInterface
{
    public function findByUuid(Uuid $uuid): ?Faculty;

    public function paginate(BaseHttpQueryParams $httpQueryParams): Paginator;

    public function list(HttpQueryFilterDTO $httpQueryFilter): FacultyCollection;

    public function save(Faculty $university): void;

    public function delete(Faculty $university): void;
}
