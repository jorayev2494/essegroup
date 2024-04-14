<?php

declare(strict_types=1);

namespace Project\Domains\Admin\University\Application\ApplicationStatusValue\Queries\Index;

use Project\Domains\Admin\University\Domain\Application\StatusValueRepositoryInterface;
use Project\Domains\Admin\University\Domain\Application\StatusValueTranslate;
use Project\Shared\Domain\Bus\Query\QueryHandlerInterface;

readonly class QueryHandler implements QueryHandlerInterface
{
    public function __construct(
        private StatusValueRepositoryInterface $statusValueRepository
    ) { }

    public function __invoke(Query $query): array
    {
        return $this->statusValueRepository->paginate($query)
            ->translateItems(StatusValueTranslate::class)
            ->toArray();
    }
}
