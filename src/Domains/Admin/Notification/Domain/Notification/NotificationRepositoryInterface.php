<?php

declare(strict_types=1);

namespace Project\Domains\Admin\Notification\Domain\Notification;

use Project\Domains\Admin\Notification\Application\Notification\Queries\Index\Query as IndexQuery;
use Project\Domains\Admin\Notification\Domain\Notification\ValueObjects\Uuid;
use \Project\Domains\Admin\Notification\Domain\Manager\ValueObjects\Uuid as ManagerUuid;
use Project\Shared\Infrastructure\Repository\Doctrine\Paginator;

interface NotificationRepositoryInterface
{
    public function paginate(IndexQuery $httpQuery): Paginator;

    public function findByUuid(Uuid $uuid): ?Notification;

    public function getQualityUnviewed(ManagerUuid $managerUuid): int;

    public function save(Notification $notification, bool $isFlush = true): void;

    public function flush(): void;
}