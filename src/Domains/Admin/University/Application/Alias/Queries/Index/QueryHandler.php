<?php

declare(strict_types=1);

namespace Project\Domains\Admin\University\Application\Alias\Queries\Index;

use Project\Domains\Admin\University\Domain\Alias\AliasRepositoryInterface;
use Project\Domains\Admin\University\Domain\Alias\AliasTranslate;
use Project\Shared\Domain\Bus\Query\QueryHandlerInterface;

readonly class QueryHandler implements QueryHandlerInterface
{
    public function __construct(
        private AliasRepositoryInterface $aliasRepository
    ) {

    }

    public function __invoke(Query $query): array
    {
        return $this->aliasRepository->paginate($query)
            ->translateItems(AliasTranslate::class)
            ->toArray();
    }
}
