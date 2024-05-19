<?php

declare(strict_types=1);

namespace Project\Domains\Public\StaticPage\Application\StaticPage\Queries\Show;

use Project\Domains\Public\StaticPage\Domain\StaticPage\Services\Contracts\StaticPageServiceInterface;
use Project\Shared\Domain\Bus\Query\QueryHandlerInterface;

readonly class QueryHandler implements QueryHandlerInterface
{
    public function __construct(
        private StaticPageServiceInterface $service
    ) { }

    public function __invoke(Query $query): array
    {
        return $this->service->show($query->slug);
    }
}
