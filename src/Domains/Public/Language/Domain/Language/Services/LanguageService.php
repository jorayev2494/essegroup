<?php

declare(strict_types=1);

namespace Project\Domains\Public\Language\Domain\Language\Services;

use Project\Domains\Public\Language\Application\Language\Queries\List\Query;
use Project\Domains\Public\Language\Domain\Language\Services\Contracts\LanguageServiceInterface;
use Project\Shared\Domain\Bus\Query\QueryBusInterface;
use Project\Domains\Admin\Language\Applications\Language\Queries\List\Query as ListQuery;

class LanguageService implements LanguageServiceInterface
{
    public function list(Query $query): array
    {
        /** @var QueryBusInterface $queryBus */
        $queryBus = resolve(QueryBusInterface::class);

        return $queryBus->ask(ListQuery::makeFromArray($query->toArray()));
    }
}
