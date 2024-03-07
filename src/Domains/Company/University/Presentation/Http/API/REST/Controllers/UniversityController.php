<?php

declare(strict_types=1);

namespace Project\Domains\Company\University\Presentation\Http\API\REST\Controllers;

use Illuminate\Contracts\Routing\ResponseFactory;
use Project\Domains\Company\University\Application\University\Queries\Index\Query as IndexQuery;
use Project\Domains\Company\University\Application\University\Queries\Index\QueryHandler as IndexQueryHandler;
use Symfony\Component\HttpFoundation\JsonResponse;

readonly class UniversityController
{
    public function __construct(
        private ResponseFactory $response,
    )
    {

    }

    public function index(IndexQueryHandler $queryHandler): JsonResponse
    {
        return $this->response->json(
            $queryHandler(
                new IndexQuery()
            )
        );
    }
}
