<?php

declare(strict_types=1);

namespace Project\Domains\Public\University\Presentation\Http\API\REST\Controllers;

use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Http\Request;
use Project\Domains\Public\University\Application\Country\Queries\List\Query;
use Project\Domains\Public\University\Application\Country\Queries\List\QueryHandler;
use Symfony\Component\HttpFoundation\JsonResponse;

readonly class CountryController
{
    public function __construct(
        private ResponseFactory $response
    )
    {

    }

    public function list(Request $request, QueryHandler $queryHandler): JsonResponse
    {
        return $this->response->json(
            $queryHandler(Query::makeFromRequest($request))
        );
    }
}
