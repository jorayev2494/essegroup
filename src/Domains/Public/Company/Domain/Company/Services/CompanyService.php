<?php

declare(strict_types=1);

namespace Project\Domains\Public\Company\Domain\Company\Services;

use Project\Domains\Admin\Company\Application\Company\Queries\List\Query;
use Project\Domains\Public\Company\Application\Company\Queries\List\Query as ListQuery;
use Project\Domains\Public\Company\Domain\Company\Services\Contracts\CompanyServiceInterface;
use Project\Shared\Domain\Bus\Query\QueryBusInterface;

readonly class CompanyService implements CompanyServiceInterface
{
    public function list(ListQuery $query): array
    {
        /** @var QueryBusInterface $queryBus */
        $queryBus = resolve(QueryBusInterface::class);

        return $queryBus->ask(new Query);
    }
}
