<?php

declare(strict_types=1);

namespace Project\Domains\Public\University\Domain\Faculty\Services\Contracts;

use Project\Domains\Admin\University\Infrastructure\Faculty\Filters\HttpQueryFilterDTO;

interface FacultyServiceInterface
{
    public function list(HttpQueryFilterDTO $httpQueryFilterDTO): array;
}
