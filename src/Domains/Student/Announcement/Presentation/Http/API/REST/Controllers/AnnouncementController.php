<?php

declare(strict_types=1);

namespace Project\Domains\Student\Announcement\Presentation\Http\API\REST\Controllers;

use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Http\Request;
use Project\Domains\Company\Announcement\Application\Announcement\Queries\Index\Query as IndexQuery;
use Project\Domains\Company\Announcement\Application\Announcement\Queries\List\Query as ListQuery;
use Project\Domains\Company\Announcement\Application\Announcement\Queries\View\Query as ViewQuery;
use Project\Shared\Domain\Bus\Query\QueryBusInterface;
use Symfony\Component\HttpFoundation\JsonResponse;

readonly class AnnouncementController
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

    public function list(Request $request): JsonResponse
    {
        return $this->response->json(
            $this->queryBus->ask(
                ListQuery::makeFromRequest($request)
            )
        );
    }

    public function view(string $uuid): JsonResponse
    {
        return $this->response->json(
            $this->queryBus->ask(
                new ViewQuery($uuid)
            )
        );
    }
}
