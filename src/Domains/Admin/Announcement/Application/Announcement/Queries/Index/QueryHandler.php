<?php

declare(strict_types=1);

namespace Project\Domains\Admin\Announcement\Application\Announcement\Queries\Index;

use Project\Domains\Admin\Announcement\Domain\Announcement\AnnouncementRepositoryInterface;
use Project\Domains\Admin\Announcement\Domain\Announcement\AnnouncementTranslate;
use Project\Domains\Admin\Announcement\Domain\Announcement\Exceptions\AnnouncementNotFoundDomainException;
use Project\Domains\Admin\Announcement\Domain\Announcement\ValueObjects\Uuid;
use Project\Shared\Domain\Bus\Query\QueryHandlerInterface;

readonly class QueryHandler implements QueryHandlerInterface
{
    public function __construct(
        private AnnouncementRepositoryInterface $repository
    ) { }

    public function __invoke(Query $query): array
    {
        return $this->repository->paginate($query)
            ->translateItems(AnnouncementTranslate::class)
            ->toArray();
    }
}
