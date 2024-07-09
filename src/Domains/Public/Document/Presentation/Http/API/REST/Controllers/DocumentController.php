<?php

declare(strict_types=1);

namespace Project\Domains\Public\Document\Presentation\Http\API\REST\Controllers;

use Illuminate\Contracts\Routing\ResponseFactory;
use Project\Domains\Public\Document\Application\Document\Queries\List\Query as ListQuery;
use Project\Domains\Public\Document\Application\Document\Queries\Download\Query as DownloadQuery;
use Project\Shared\Domain\Bus\Query\QueryBusInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\StreamedResponse;

readonly class DocumentController
{
    public function __construct(
        private ResponseFactory $response,
        private QueryBusInterface $queryBus
    ) { }

    public function list(Request $request): JsonResponse
    {
        return $this->response->json(
            $this->queryBus->ask(
                ListQuery::makeFromRequest($request)
            )
        );
    }

    public function download(string $uuid): StreamedResponse
    {
        return $this->queryBus->ask(
            new DownloadQuery($uuid)
        );
    }
}
