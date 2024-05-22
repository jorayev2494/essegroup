<?php

declare(strict_types=1);

namespace Project\Domains\Public\Document\Application\Document\Queries\List;

use Project\Domains\Public\Document\Domain\Document\Services\Contracts\DocumentServiceInterface;
use Project\Shared\Domain\Bus\Query\QueryHandlerInterface;

readonly class QueryHandler implements QueryHandlerInterface
{
    public function __construct(
        private DocumentServiceInterface $service
    ) { }

    public function __invoke(Query $query): array
    {
        return $this->service->list($query);
    }
}
