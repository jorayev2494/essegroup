<?php

declare(strict_types=1);

namespace Project\Domains\Company\Company\Application\Company\Queries\Show;

use Project\Domains\Company\Company\Domain\Company\CompanyRepositoryInterface;
use Project\Domains\Company\Company\Domain\Company\Exceptions\CompanyNotFoundDomainException;
use Project\Domains\Company\Company\Domain\Company\ValueObjects\Uuid;
use Project\Infrastructure\Services\Auth\AuthManager;
use Project\Shared\Domain\Bus\Query\QueryHandlerInterface;

readonly class QueryHandler implements QueryHandlerInterface
{
    public function __construct(
         private CompanyRepositoryInterface $repository
    )
    {

    }

    public function __invoke(Query $query): array
    {
        return $this->repository->findByUuid(Uuid::fromValue(AuthManager::getCompanyUuid()))->toArray();
    }
}
