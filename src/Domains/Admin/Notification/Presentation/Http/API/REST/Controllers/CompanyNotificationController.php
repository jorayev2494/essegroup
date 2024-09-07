<?php

declare(strict_types=1);

namespace Project\Domains\Admin\Notification\Presentation\Http\API\REST\Controllers;

use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Http\Request;
use Project\Domains\Admin\Notification\Application\Notification\Queries\Index\Query as IndexQuery;
use Project\Domains\Admin\Notification\Application\Notification\Commands\Create\Command as CreateCommand;
use Project\Domains\Admin\Notification\Application\Notification\Queries\GetQuantityUnviewed\Query as GetQuantityUnviewedQuery;
use Project\Shared\Domain\Bus\Command\CommandBusInterface;
use Project\Shared\Domain\Bus\Query\QueryBusInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

readonly class CompanyNotificationController
{
    public function __construct(
        private ResponseFactory $response,
        private QueryBusInterface $queryBus,
        private CommandBusInterface $commandBus
    ) { }

    public function index(Request $request): JsonResponse
    {
        return $this->response->json(
            $this->queryBus->ask(
                IndexQuery::makeFromRequest($request)
            )->toResponse()
        );
    }

    public function getQuantityUnviewed(): JsonResponse
    {
        return $this->response->json(
            $this->queryBus->ask(
                new GetQuantityUnviewedQuery()
            )->toResponse()
        );
    }

    public function testDefault(): Response
    {
        $this->commandBus->dispatch(
            new CreateCommand()
        );

        return $this->response->noContent();
    }
}