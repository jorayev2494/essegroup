<?php

declare(strict_types=1);

namespace Project\Domains\Admin\Company\Application\Company\Queries\Show;

use Project\Domains\Admin\Company\Domain\Company\CompanyRepositoryInterface;
use Project\Domains\Admin\Company\Domain\Company\Exceptions\CompanyNotFoundDomainException;
use Project\Domains\Admin\Company\Domain\Company\ValueObjects\Uuid;
use Project\Shared\Contracts\ArrayableInterface;
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
        $company = $this->repository->findByUuid(Uuid::fromValue($query->uuid));

        $company ?? throw new CompanyNotFoundDomainException();

        return $company->toArray();
    }
}
