<?php

declare(strict_types=1);

namespace Project\Domains\Public\University\Presentation\Http\API\REST\Controllers;

use Illuminate\Contracts\Routing\ResponseFactory;
use Project\Domains\Public\University\Application\University\Queries\Index\Query;
use Project\Shared\Domain\Bus\Query\QueryBusInterface;
use Symfony\Component\HttpFoundation\JsonResponse;

readonly class UniversityController
{
    public function __construct(
        private ResponseFactory $response,
        private QueryBusInterface $queryBus
    )
    {

    }

    public function index(): JsonResponse
    {
        return $this->response->json(
            $this->queryBus->ask(
                new Query()
            )
        );
    }

    public function show(string $uuid): JsonResponse
    {
        return $this->response->json(
            $this->queryBus->ask(
                new \Project\Domains\Public\University\Application\University\Queries\Show\Query($uuid)
            )
        );
    }
}
