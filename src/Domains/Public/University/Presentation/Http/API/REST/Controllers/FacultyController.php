<?php

declare(strict_types=1);

namespace Project\Domains\Public\University\Presentation\Http\API\REST\Controllers;

use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Http\Request;
use Project\Domains\Public\University\Application\Faculty\Queries\List\Query as ListQuery;
use Project\Domains\Public\University\Application\Faculty\Queries\List\QueryHandler as ListQueryHandler;
use Project\Domains\Public\University\Application\Faculty\Queries\Show\QueryHandler as ShowQueryHandler;
use Project\Domains\Public\University\Application\Faculty\Queries\Show\Query as ShowQuery;
use Symfony\Component\HttpFoundation\JsonResponse;

readonly class FacultyController
{
    public function __construct(
        private ResponseFactory $response
    ) {

    }

    public function list(Request $request, ListQueryHandler $queryHandler): JsonResponse
    {
        return $this->response->json(
            $queryHandler(
                ListQuery::makeFromRequest($request)
            )
        );
    }

    public function show(string $uuid, ShowQueryHandler $queryHandler): JsonResponse
    {
        return $this->response->json(
            $queryHandler(
                new ShowQuery($uuid)
            )
        );
    }
}
