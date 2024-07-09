<?php

declare(strict_types=1);

namespace Project\Domains\Company\Announcement\Domain\Announcement\Services;

use Project\Domains\Admin\Announcement\Application\Announcement\Queries\Index\Query as AdminIndexQuery;
use Project\Domains\Admin\Announcement\Application\Announcement\Queries\List\Query as AdminListQuery;
use Project\Domains\Admin\Announcement\Application\Announcement\Queries\View\Query as AdminViewQuery;
use Project\Domains\Admin\Announcement\Domain\Announcement\ValueObjects\ForItemEnum;
use Project\Domains\Company\Announcement\Application\Announcement\Queries\Index\Query as IndexQuery;
use Project\Domains\Company\Announcement\Application\Announcement\Queries\List\Query as ListQuery;
use Project\Domains\Company\Announcement\Domain\Announcement\Services\Contracts\AnnouncementServiceInterface;
use Project\Shared\Domain\Bus\Query\QueryBusInterface;
use Project\Shared\Domain\ValueObject\UuidValueObject;

class AnnouncementService implements AnnouncementServiceInterface
{
    public function index(IndexQuery $httpQuery): array
    {
        /** @var QueryBusInterface $queryBus */
        $queryBus = resolve(QueryBusInterface::class);

        return $queryBus->ask(
            AdminIndexQuery::makeFromArray(
                array_merge(
                    $httpQuery->toArray(),
                    [
                        'for_items' => [
                            ForItemEnum::ANYONE,
                            ForItemEnum::COMPANY,
                        ],
                        'activity' => true,
                    ]
                )
            )
        );
    }

    public function list(ListQuery $httpQuery): array
    {
        /** @var QueryBusInterface $queryBus */
        $queryBus = resolve(QueryBusInterface::class);

        return $queryBus->ask(
            AdminListQuery::makeFromArray(
                array_merge(
                    $httpQuery->toArray(),
                    [
                        'for_items' => [
                            ForItemEnum::ANYONE,
                            ForItemEnum::COMPANY,
                        ],
                        'activity' => true,
                    ]
                )
            )
        );
    }

    public function view(UuidValueObject $uuid): array
    {
        /** @var QueryBusInterface $queryBus */
        $queryBus = resolve(QueryBusInterface::class);

        return $queryBus->ask(
            new AdminViewQuery($uuid->value)
        );
    }
}
