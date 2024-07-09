<?php

declare(strict_types=1);

namespace Project\Domains\Public\YouTube\Domian\YouTube\Services;

use Project\Domains\Admin\YouTube\Application\YouTube\Queries\ListVideos\Query as ListVideosQuery;
use Project\Domains\Public\YouTube\Domian\YouTube\Services\Contracts\YouTubeApiServiceInterface;
use Project\Shared\Domain\Bus\Query\QueryBusInterface;

readonly class YouTubeApiService implements YouTubeApiServiceInterface
{
    public function listVideos(): array
    {
        /** @var QueryBusInterface $queryBus */
        $queryBus = resolve(QueryBusInterface::class);

        return $queryBus->ask(new ListVideosQuery());
    }
}
