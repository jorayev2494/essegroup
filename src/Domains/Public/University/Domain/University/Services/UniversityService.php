<?php

declare(strict_types=1);

namespace Project\Domains\Public\University\Domain\University\Services;

use Project\Domains\Public\University\Application\University\Queries\List\Query;
use Project\Domains\Public\University\Domain\University\Services\Contracts\UniversityServiceInterface;
use Project\Shared\Domain\Bus\Query\QueryBusInterface;

readonly class UniversityService implements Contracts\UniversityServiceInterface
{
    public function __construct(
        private QueryBusInterface $queryBus
    )
    {

    }

    public function list(Query $query): array
    {
        // return $this->queryBus->ask(new \Project\Domains\Admin\University\Application\University\Queries\List\QueryHandler())
    }
}
