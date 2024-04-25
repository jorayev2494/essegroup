<?php

declare(strict_types=1);

namespace Project\Domains\Company\University\Application\Application\Queries\Index;

use Project\Domains\Company\University\Domain\Aplication\Services\Contracts\ApplicationServiceInterface;
use Project\Infrastructure\Services\Auth\AuthManager;
use Project\Shared\Domain\Bus\Query\QueryHandlerInterface;

readonly class QueryHandler implements QueryHandlerInterface
{
    public function __construct(
        private ApplicationServiceInterface $service
    ) { }

    public function __invoke(Query $query): array
    {
        return $this->service->index(AuthManager::companyUuid(), $query);
    }
}
