<?php

declare(strict_types=1);

namespace Project\Domains\Company\University\Application\Application\Queries\Show;

use Project\Domains\Company\University\Domain\Aplication\Services\Contracts\ApplicationServiceInterface;
use Project\Shared\Domain\Bus\Query\QueryHandlerInterface;

readonly class QueryHandler implements QueryHandlerInterface
{
    public function __construct(
        private ApplicationServiceInterface $service
    ) { }

    public function __invoke(Query $query): array
    {
        return $this->service->show($query);
    }
}
