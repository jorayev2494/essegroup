<?php

namespace Project\Domains\Public\University\Domain\University;

use Project\Domains\Admin\University\Domain\Company\ValueObjects\Uuid;
use Project\Domains\Admin\University\Domain\University\University;
use Project\Domains\Admin\University\Domain\University\UniversityCollection;
use Project\Domains\Admin\University\Infrastructure\University\Filters\HttpQueryFilterDTO;

interface UniversityRepositoryInterface
{
    public function list(HttpQueryFilterDTO $httpQueryFilterDTO): UniversityCollection;

    public function findByUuid(Uuid $uuid): ?University;
}
