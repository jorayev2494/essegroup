<?php

declare(strict_types=1);

namespace Project\Domains\Public\Company\Application\Company\Queries\List;

use Project\Domains\Public\Company\Domain\Company\Services\Contracts\CompanyServiceInterface;
use Project\Shared\Domain\Bus\Query\QueryHandlerInterface;

readonly class QueryHandler implements QueryHandlerInterface
{
    public function __construct(
        private CompanyServiceInterface $service
    ) { }

    public function __invoke(Query $query): array
    {
        return $this->service->list($query);
    }
}
