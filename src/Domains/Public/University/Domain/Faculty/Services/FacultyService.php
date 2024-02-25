<?php

declare(strict_types=1);

namespace Project\Domains\Public\University\Domain\Faculty\Services;

use Project\Domains\Admin\University\Application\Faculty\Queries\List\Query;
use Project\Domains\Public\University\Domain\Faculty\Services\Contracts\FacultyServiceInterface;
use Project\Shared\Domain\Bus\Query\QueryBusInterface;
use Project\Domains\Admin\University\Infrastructure\Faculty\Filters\HttpQueryFilterDTO;

readonly class FacultyService implements FacultyServiceInterface
{
    public function __construct(
        private QueryBusInterface $queryBus
    ) {

    }

    public function list(HttpQueryFilterDTO $httpQueryFilterDTO): array
    {
        return $this->queryBus->ask(
            Query::makeFromArray($httpQueryFilterDTO->toArray())
        );
    }
}
