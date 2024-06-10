<?php

declare(strict_types=1);

namespace Project\Domains\Company\University\Domain\ApplicationStatusValue\Services;

use Project\Domains\Company\University\Application\ApplicationStatusValue\Queries\List\Query;
use Project\Domains\Company\University\Application\ApplicationStatusValue\Queries\List\Query as ListQuery;
use Project\Domains\Company\University\Application\ApplicationStatusValue\Queries\WidgetList\Query as WidgetListQuery;
use Project\Domains\Company\University\Domain\ApplicationStatusValue\Services\Contracts\ApplicationStatusValueServiceInterface;
use Project\Infrastructure\Services\Auth\AuthManager;
use Project\Shared\Domain\Bus\Query\QueryBusInterface;

readonly class ApplicationStatusValueService implements ApplicationStatusValueServiceInterface
{
    public function list(ListQuery $httpQuery): array
    {
        /** @var QueryBusInterface $queryBus */
        $queryBus = resolve(QueryBusInterface::class);

        return $queryBus->ask(
            new \Project\Domains\Admin\University\Application\ApplicationStatusValue\Queries\List\Query()
        );
    }

    public function widgetList(WidgetListQuery $httpQuery): array
    {
        /** @var QueryBusInterface $queryBus */
        $queryBus = resolve(QueryBusInterface::class);

        return $queryBus->ask(
            \Project\Domains\Admin\University\Application\ApplicationStatusValue\Queries\WidgetList\Query::makeFromArray(
                [
                    ...$httpQuery->toArray(),
                    'company_uuids' => [
                        AuthManager::companyUuid()->value,
                    ],
                ]
            )
        );
    }
}
