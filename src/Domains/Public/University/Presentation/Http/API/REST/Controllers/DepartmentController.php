<?php

declare(strict_types=1);

namespace Project\Domains\Public\University\Presentation\Http\API\REST\Controllers;

use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Http\Request;
use Project\Domains\Public\University\Application\Department\Queries\List\QueryHandler as ListQueryHandler;
use Project\Domains\Public\University\Application\Department\Queries\List\Query as ListQuery;
use Symfony\Component\HttpFoundation\JsonResponse;

readonly class DepartmentController
{
    public function __construct(
        private ResponseFactory $response
    )
    {

    }

    public function list(Request $request, ListQueryHandler $queryHandler): JsonResponse
    {
        return $this->response->json(
            $queryHandler(
                ListQuery::makeFromRequest($request)
            )
        );
    }
}
