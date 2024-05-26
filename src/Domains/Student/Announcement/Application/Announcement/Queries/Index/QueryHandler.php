<?php

declare(strict_types=1);

namespace Project\Domains\Student\Announcement\Application\Announcement\Queries\Index;

use Project\Domains\Student\Announcement\Domain\Announcement\Services\Contracts\AnnouncementServiceInterface;
use Project\Shared\Domain\Bus\Query\QueryHandlerInterface;

readonly class QueryHandler implements QueryHandlerInterface
{
    public function __construct(
        private AnnouncementServiceInterface $service
    ) { }

    public function __invoke(Query $query): array
    {
        return $this->service->index($query);
    }
}
