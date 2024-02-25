<?php

declare(strict_types=1);

namespace Project\Domains\Public\University\Domain\Country\Services\Contracts;

use Project\Domains\Admin\University\Infrastructure\Country\Filters\HttpQueryFilterDTO;

interface CountryServiceInterface
{
    public function list(HttpQueryFilterDTO $queryFilterDTO): array;
}
