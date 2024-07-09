<?php

declare(strict_types=1);

namespace Project\Domains\Company\Announcement\Application\Announcement\Queries\View;

use Project\Domains\Company\Announcement\Domain\Announcement\Services\Contracts\AnnouncementServiceInterface;
use Project\Shared\Domain\Bus\Query\QueryHandlerInterface;
use Project\Shared\Domain\ValueObject\UuidValueObject;

readonly class QueryHandler implements QueryHandlerInterface
{
    public function __construct(
        private AnnouncementServiceInterface $service
    ) { }

    public function __invoke(Query $query): array
    {
        return $this->service->view(UuidValueObject::fromValue($query->uuid));
    }
}
