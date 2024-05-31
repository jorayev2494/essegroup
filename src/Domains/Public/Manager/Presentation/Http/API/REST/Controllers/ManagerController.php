<?php

declare(strict_types=1);

namespace Project\Domains\Public\Manager\Presentation\Http\API\REST\Controllers;

use Illuminate\Contracts\Routing\ResponseFactory;
use Project\Domains\Public\Manager\Application\Manager\Queries\List\Query as ListQuery;
use Project\Domains\Public\Manager\Application\Manager\Queries\Show\Query as ShowQuery;
use Project\Shared\Domain\Bus\Query\QueryBusInterface;
use Symfony\Component\HttpFoundation\JsonResponse;

readonly class ManagerController
{
    public function __construct(
        private ResponseFactory $response,
        private QueryBusInterface $queryBus
    ) { }

    public function list(): JsonResponse
    {
        return $this->response->json(
            $this->queryBus->ask(
                new ListQuery()
            )
        );
    }

    public function show(string $uuid): JsonResponse
    {
        return $this->response->json(
            $this->queryBus->ask(
                new ShowQuery($uuid)
            )
        );
    }
}
