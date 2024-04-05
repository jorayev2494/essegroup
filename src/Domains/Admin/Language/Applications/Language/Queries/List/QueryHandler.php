<?php

declare(strict_types=1);

namespace Project\Domains\Admin\Language\Applications\Language\Queries\List;

use Project\Domains\Admin\Language\Domain\Language\LanguageRepositoryInterface;
use Project\Shared\Domain\Bus\Query\QueryHandlerInterface;

readonly class QueryHandler implements QueryHandlerInterface
{
    public function __construct(
       private LanguageRepositoryInterface $repository
    ) {

    }

    public function __invoke(Query $query): array
    {
        return $this->repository->list()->translateItems()->toArray();
    }
}
