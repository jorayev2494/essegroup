<?php

declare(strict_types=1);

namespace Project\Domains\Public\University\Domain\Faculty\Services;

use Project\Domains\Admin\University\Application\Faculty\Queries\List\Query as ListQuery;
use Project\Domains\Admin\University\Application\Faculty\Queries\Show\Query as ShowQuery;
use Project\Domains\Public\University\Domain\Faculty\Services\Contracts\FacultyServiceInterface;
use Project\Shared\Domain\Bus\Query\QueryBusInterface;
use Project\Domains\Admin\University\Infrastructure\Faculty\Filters\QueryFilter;

readonly class FacultyService implements FacultyServiceInterface
{
    public function __construct(
        private QueryBusInterface $queryBus
    ) {

    }

    public function list(QueryFilter $queryFilter): array
    {
        return $this->queryBus->ask(
            ListQuery::makeFromArray($queryFilter->toArray())
        );
    }

    public function show(string $uuid): array
    {
        return $this->queryBus->ask(
            new ShowQuery($uuid)
        );
    }
}
