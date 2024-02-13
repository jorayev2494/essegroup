<?php

declare(strict_types=1);

namespace Project\Domains\Admin\University\Application\Application\Queries\Show;

use Project\Domains\Admin\University\Domain\Application\ApplicationRepositoryInterface;
use Project\Domains\Admin\University\Domain\Application\Exceptions\ApplicationNotFoundDomainException;
use Project\Domains\Admin\University\Domain\Application\ValueObjects\Uuid;
use Project\Shared\Domain\Bus\Query\QueryHandlerInterface;

readonly class QueryHandler implements QueryHandlerInterface
{
    public function __construct(
        private ApplicationRepositoryInterface $applicationRepository
    )
    {

    }

    public function __invoke(Query $query): array
    {
        $application = $this->applicationRepository->findByUuid(Uuid::fromValue($query->uuid));

        $application ?? throw new ApplicationNotFoundDomainException();

        return $application->toArray();
    }
}
