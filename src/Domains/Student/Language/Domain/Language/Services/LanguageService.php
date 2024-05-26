<?php

declare(strict_types=1);

namespace Project\Domains\Student\Language\Domain\Language\Services;

use Project\Domains\Student\Language\Application\Language\Queries\List\Query;
use Project\Domains\Student\Language\Domain\Language\Services\Contracts\LanguageServiceInterface;
use Project\Shared\Domain\Bus\Query\QueryBusInterface;

class LanguageService implements LanguageServiceInterface
{
    public function list(Query $query): array
    {
        /** @var QueryBusInterface $queryBus */
        $queryBus = resolve(QueryBusInterface::class);

        return $queryBus->ask(
            \Project\Domains\Admin\Language\Applications\Language\Queries\List\Query::makeFromArray(
                $query->toArray()
            )
        );
    }
}
