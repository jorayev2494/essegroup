<?php

namespace Project\Domains\Public\University\Domain\University;

use Project\Domains\Admin\University\Domain\Company\ValueObjects\Uuid;
use Project\Domains\Admin\University\Domain\University\University;
use Project\Domains\Admin\University\Domain\University\UniversityCollection;
use Project\Domains\Admin\University\Infrastructure\University\Filters\QueryFilter;

interface UniversityRepositoryInterface
{
    public function list(QueryFilter $queryFilter): UniversityCollection;

    public function findByUuid(Uuid $uuid): ?University;
}
