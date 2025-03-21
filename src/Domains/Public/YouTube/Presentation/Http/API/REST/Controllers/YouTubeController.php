<?php

declare(strict_types=1);

namespace Project\Domains\Public\YouTube\Presentation\Http\API\REST\Controllers;

use Illuminate\Contracts\Routing\ResponseFactory;
use Project\Domains\Public\YouTube\Application\YouTube\Queries\ListVideos\Query;
use Project\Shared\Domain\Bus\Query\QueryBusInterface;
use Symfony\Component\HttpFoundation\JsonResponse;

readonly class YouTubeController
{
    public function __construct(
        private ResponseFactory $response,
        private QueryBusInterface $queryBus
    ) { }

    public function listVideos(): JsonResponse
    {
        return $this->response->json(
            $this->queryBus->ask(
                new Query()
            )
        );
    }
}
