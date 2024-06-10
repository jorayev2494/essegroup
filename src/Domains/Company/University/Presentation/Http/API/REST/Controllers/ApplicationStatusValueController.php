<?php

declare(strict_types=1);

namespace Project\Domains\Company\University\Presentation\Http\API\REST\Controllers;

use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Http\Request;
use Project\Domains\Company\University\Application\ApplicationStatusValue\Queries\List\Query as ListQuery;
use Project\Domains\Company\University\Application\ApplicationStatusValue\Queries\WidgetList\Query as WidgetListQuery;
use Project\Shared\Domain\Bus\Query\QueryBusInterface;
use Symfony\Component\HttpFoundation\JsonResponse;

readonly class ApplicationStatusValueController
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

    public function widgetList(Request $request): JsonResponse
    {
        return $this->response->json(
            $this->queryBus->ask(
                WidgetListQuery::makeFromRequest($request)
            )
        );
    }
}
