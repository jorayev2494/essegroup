<?php

declare(strict_types=1);

namespace Project\Domains\Admin\Announcement\Domain\Announcement;

use Project\Domains\Admin\Announcement\Application\Announcement\Queries\Index\Query as IndexQuery;
use Project\Domains\Admin\Announcement\Application\Announcement\Queries\List\Query as ListQuery;
use Project\Domains\Admin\Announcement\Domain\Announcement\ValueObjects\Uuid;
use Project\Shared\Infrastructure\Repository\Doctrine\Paginator;

interface AnnouncementRepositoryInterface
{
    public function paginate(IndexQuery $httpQuery): Paginator;

    public function list(ListQuery $httpQuery): AnnouncementCollection;

    public function findByUuid(Uuid $uuid): ?Announcement;

    public function save(Announcement $announcement): void;

    public function delete(Announcement $announcement): void;
}
