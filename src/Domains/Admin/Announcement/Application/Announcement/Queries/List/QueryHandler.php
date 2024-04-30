<?php

declare(strict_types=1);

namespace Project\Domains\Admin\Announcement\Application\Announcement\Queries\List;

use Project\Domains\Admin\Announcement\Domain\Announcement\AnnouncementRepositoryInterface;
use Project\Shared\Domain\Bus\Query\QueryHandlerInterface;

readonly class QueryHandler implements QueryHandlerInterface
{
    public function __construct(
        private AnnouncementRepositoryInterface $repository
    ) { }

    public function __invoke(Query $query): array
    {
        return $this->repository->list($query)->translateItems()->toArray();
    }
}
