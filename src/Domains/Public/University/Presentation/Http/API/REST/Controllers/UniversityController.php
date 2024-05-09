<?php

declare(strict_types=1);

namespace Project\Domains\Public\University\Presentation\Http\API\REST\Controllers;

use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Http\Request;
use Project\Domains\Public\University\Application\University\Queries\List\QueryHandler as ListQueryHandler;
use Project\Domains\Public\University\Application\University\Queries\List\Query as ListQuery;
use Project\Domains\Public\University\Application\University\Queries\Index\Query as IndexQuery;
use Project\Domains\Public\University\Application\University\Queries\Search\Query;
use Project\Shared\Domain\Bus\Query\QueryBusInterface;
use Symfony\Component\HttpFoundation\JsonResponse;

readonly class UniversityController
{
    public function __construct(
        private ResponseFactory $response,
        private QueryBusInterface $queryBus
    ) { }

    public function index(Request $request): JsonResponse
    {
        return $this->response->json(
            $this->queryBus->ask(
                IndexQuery::makeFromRequest($request)
            )
        );
    }

    public function list(Request $request, ListQueryHandler $queryHandler): JsonResponse
    {
        return $this->response->json(
            $queryHandler(ListQuery::makeFromRequest($request))
        );
    }

    public function search(Request $request): JsonResponse
    {
        return $this->response->json(
            $this->queryBus->ask(
                Query::makeFromRequest($request)
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
