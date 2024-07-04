<?php

declare(strict_types=1);

namespace Project\Domains\Public\YouTube\Application\YouTube\Queries\ListVideos;

use Project\Domains\Public\YouTube\Domian\YouTube\Services\Contracts\YouTubeApiServiceInterface;
use Project\Shared\Domain\Bus\Query\QueryHandlerInterface;

readonly class QueryHandler implements QueryHandlerInterface
{
    public function __construct(
        private YouTubeApiServiceInterface $service
    ) { }

    public function __invoke(Query $query): array
    {
        return $this->service->listVideos();
    }
}
