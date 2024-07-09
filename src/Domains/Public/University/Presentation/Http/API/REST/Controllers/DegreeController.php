<?php

declare(strict_types=1);

namespace Project\Domains\Public\University\Presentation\Http\API\REST\Controllers;

use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Project\Domains\Public\University\Application\Degree\Queries\List\Query;
use Project\Shared\Domain\Bus\Query\QueryBusInterface;

class DegreeController
{
    public function __construct(
        private ResponseFactory $response,
        private QueryBusInterface $queryBus
    ) {

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
