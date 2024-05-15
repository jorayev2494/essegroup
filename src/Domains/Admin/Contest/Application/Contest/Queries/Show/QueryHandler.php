<?php

declare(strict_types=1);

namespace Project\Domains\Admin\Contest\Application\Contest\Queries\Show;

use Project\Domains\Admin\Contest\Domain\Contest\ContestRepositoryInterface;
use Project\Domains\Admin\Contest\Domain\Contest\ContestTranslate;
use Project\Domains\Admin\Contest\Domain\Contest\Exceptions\ContestNotFoundDomainException;
use Project\Domains\Admin\Contest\Domain\Contest\ValueObjects\Uuid;
use Project\Shared\Domain\Bus\Query\QueryHandlerInterface;

readonly class QueryHandler implements QueryHandlerInterface
{
    public function __construct(
        private ContestRepositoryInterface $repository
    ) { }

    public function __invoke(Query $query): array
    {
        $contest = $this->repository->findByUuid(Uuid::fromValue($query->uuid));

        $contest ?? throw new ContestNotFoundDomainException();

        return ContestTranslate::execute($contest)->toArrayWithTranslations();
    }
}
