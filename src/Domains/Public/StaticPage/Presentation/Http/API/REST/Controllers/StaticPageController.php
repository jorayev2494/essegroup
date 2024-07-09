<?php

declare(strict_types=1);

namespace Project\Domains\Public\StaticPage\Presentation\Http\API\REST\Controllers;

use Illuminate\Contracts\Routing\ResponseFactory;
use Project\Domains\Public\StaticPage\Application\StaticPage\Queries\Show\Query as ShowQuery;
use Project\Shared\Domain\Bus\Query\QueryBusInterface;
use Symfony\Component\HttpFoundation\JsonResponse;

readonly class StaticPageController
{
    public function __construct(
        private ResponseFactory $response,
        private QueryBusInterface $queryBus
    ) { }

    public function show(string $slug): JsonResponse
    {
        return $this->response->json(
            $this->queryBus->ask(
                new ShowQuery(
                    $slug
                )
            )
        );
    }
}
