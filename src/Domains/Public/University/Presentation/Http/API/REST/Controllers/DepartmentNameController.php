<?php

declare(strict_types=1);

namespace Project\Domains\Public\University\Presentation\Http\API\REST\Controllers;

use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Http\Request;
use Project\Domains\Public\University\Application\DepartmentName\Queries\List\Query as ListQuery;
use Project\Domains\Public\University\Application\DepartmentName\Queries\Show\Query as ShowQuery;
use Project\Shared\Domain\Bus\Query\QueryBusInterface;
use Symfony\Component\HttpFoundation\JsonResponse;

readonly class DepartmentNameController
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
                ListQuery::makeFromRequest($request)
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
