<?php

declare(strict_types=1);

namespace Project\Domains\Student\Profile\Application\Profile\Queries\Show;

use Project\Infrastructure\Services\Auth\AuthManager;
use Project\Shared\Domain\Bus\Query\QueryHandlerInterface;

readonly class QueryHandler implements QueryHandlerInterface
{
    public function __invoke(Query $query): array
    {
        return AuthManager::student()->toArray();
    }
}
