<?php

declare(strict_types=1);

namespace Project\Domains\Company\University\Application\University\Queries\Index;

use Project\Domains\Company\University\Domain\University\Services\Contracts\UniversityServiceInterface;
use Project\Shared\Domain\Bus\Query\QueryHandlerInterface;

readonly class QueryHandler implements QueryHandlerInterface
{
    public function __construct(
        private UniversityServiceInterface $service
    )
    {

    }

    public function __invoke(Query $query): array
    {
        // dd($this->service);
        // dd(__METHOD__, $query);
        $this->service->index('awdadw');

        return [];
    }
}
