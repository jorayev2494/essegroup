<?php

declare(strict_types=1);

namespace Project\Domains\Admin\Notification\Application\Notification\Queries\GetQuantityUnviewed;

use Project\Domains\Admin\Notification\Application\Notification\Queries\GetQuantityUnviewed\Output\Output;
use Project\Domains\Admin\Notification\Domain\Notification\NotificationRepositoryInterface;
use Project\Shared\Domain\Bus\Query\QueryHandlerInterface;

readonly class QueryHandler implements QueryHandlerInterface
{
    public function __construct(
        private NotificationRepositoryInterface $repository
    ) { }

    public function __invoke(Query $query): Output
    {
        // $count = $this->repository->getQualityUnviewed(Uuid::fromValue(AuthManager::managerUuid()->value));
        $count = random_int(0, 150);

        return Output::make($count);
    }
}