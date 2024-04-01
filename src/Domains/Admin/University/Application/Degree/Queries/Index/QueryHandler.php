<?php

declare(strict_types=1);

namespace Project\Domains\Admin\University\Application\Degree\Queries\Index;

use Project\Domains\Admin\University\Domain\Degree\DegreeRepositoryInterface;
use Project\Domains\Admin\University\Domain\Degree\DegreeTranslate;
use Project\Shared\Domain\Bus\Query\QueryHandlerInterface;

readonly class QueryHandler implements QueryHandlerInterface
{
    public function __construct(
        private DegreeRepositoryInterface $degreeRepository
    ) {

    }

    public function __invoke(Query $query): array
    {
        return $this->degreeRepository->paginate($query)
            ->translateItems(DegreeTranslate::class)
            ->toArray();
    }
}
