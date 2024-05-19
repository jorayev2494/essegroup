<?php

declare(strict_types=1);

namespace Project\Domains\Public\StaticPage\Domain\StaticPage\Services;

use Project\Domains\Admin\StaticPage\Applicaiton\StaticPage\Queries\Show\Query as ShowQuery;
use Project\Domains\Public\StaticPage\Domain\StaticPage\Services\Contracts\StaticPageServiceInterface;
use Project\Shared\Domain\Bus\Query\QueryBusInterface;

class StaticPageService implements StaticPageServiceInterface
{
    public function show(string $uuid): array
    {
        /** @var QueryBusInterface $queryBus */
        $queryBus = resolve(QueryBusInterface::class);

        return $queryBus->ask(
            new ShowQuery(
                $uuid
            )
        );
    }
}
