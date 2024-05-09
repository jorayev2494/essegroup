<?php

declare(strict_types=1);

namespace Project\Domains\Public\University\Presentation\Http\API\REST\Controllers;

use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Http\Request;
use Project\Domains\Public\University\Application\Department\Queries\Index\Query as IndexQuery;
use Project\Domains\Public\University\Application\Department\Queries\List\Query as ListQuery;
use Project\Shared\Domain\Bus\Query\QueryBusInterface;
use Symfony\Component\HttpFoundation\JsonResponse;

readonly class DepartmentController
{
    public function __construct(
        private ResponseFactory $response,
        private QueryBusInterface $queryBus
    )
    {

    }

    public function index(Request $request): JsonResponse
    {
        return $this->response->json(
            $this->queryBus->ask(
                IndexQuery::makeFromRequest($request)
            )
        );
    }

    public function list(Request $request): JsonResponse
    {
        return $this->response->json(
            $this->queryBus->ask(
                ListQuery::makeFromRequest($request)
            )
        );
    }
}
