<?php

declare(strict_types=1);

namespace Project\Domains\Student\University\Application\Application\Queries\Index;

use Project\Domains\Student\University\Domain\Aplication\Services\Contracts\ApplicationServiceInterface;
use Project\Infrastructure\Services\Auth\AuthManager;
use Project\Shared\Domain\Bus\Query\QueryHandlerInterface;

readonly class QueryHandler implements QueryHandlerInterface
{
    public function __construct(
        private ApplicationServiceInterface $service
    ) { }

    public function __invoke(Query $query): array
    {
        return $this->service->index(AuthManager::studentUuid(), $query);
    }
}
