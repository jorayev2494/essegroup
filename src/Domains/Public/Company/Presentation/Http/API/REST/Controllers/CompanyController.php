<?php

declare(strict_types=1);

namespace Project\Domains\Public\Company\Presentation\Http\API\REST\Controllers;

use Illuminate\Contracts\Routing\ResponseFactory;
use Project\Domains\Public\Company\Application\Company\Queries\List\Query as ListQuery;
use Project\Shared\Domain\Bus\Query\QueryBusInterface;
use Symfony\Component\HttpFoundation\JsonResponse;

readonly class CompanyController
{
    public function __construct(
        private ResponseFactory $response,
        private QueryBusInterface $queryBus
    ) { }

    public function list(): JsonResponse
    {
        return $this->response->json(
            $this->queryBus->ask(
                new ListQuery
            )
        );
    }
}
