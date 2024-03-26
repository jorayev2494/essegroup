<?php

declare(strict_types=1);

namespace Project\Domains\Public\University\Presentation\Http\API\REST\Controllers;

use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Http\Request;
use Project\Domains\Public\University\Application\City\Queries\List\Query;
use Project\Shared\Domain\Bus\Query\QueryBusInterface;
use Symfony\Component\HttpFoundation\JsonResponse;

readonly class CityController
{
    public function __construct(
        private ResponseFactory $response,
        private QueryBusInterface $queryBus
    )
    {

    }

    public function list(Request $request): JsonResponse
    {
        return $this->response->json(
            $this->queryBus->ask(
                Query::makeFromRequest($request)
            )
        );
    }
}
