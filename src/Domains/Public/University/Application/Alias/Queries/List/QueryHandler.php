<?php

declare(strict_types=1);

namespace Project\Domains\Public\University\Application\Alias\Queries\List;

use Project\Domains\Public\University\Domain\Alias\Services\Contracts\AliasServiceInterface;
use Project\Shared\Domain\Bus\Query\QueryHandlerInterface;

readonly class QueryHandler implements QueryHandlerInterface
{
    public function __construct(
        private AliasServiceInterface $service
    ) {

    }

    public function __invoke(Query $query): array
    {
        return $this->service->list($query);
    }
}
