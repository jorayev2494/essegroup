<?php

declare(strict_types=1);

namespace Project\Domains\Admin\Manager\Presentation\Http\API\REST\Controllers;

use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Http\Request;
use Project\Domains\Admin\Manager\Application\Permission\Queries\Index\Query as IndexQuery;
use Project\Domains\Admin\Manager\Application\Permission\Queries\List\Query as ListQuery;
use Project\Domains\Admin\Manager\Application\Permission\Queries\Show\Query as ShowQuery;
use Project\Domains\Admin\Manager\Application\Permission\Commands\Update\Command as UpdateCommand;
use Project\Domains\Admin\Manager\Application\Permission\Queries\GetPermissionsByRoleUuid\Query as GetPermissionsByRoleUuidQuery;
use App\Http\Requests\Api\Admin\Manager\Role\Permission\UpdateRequest;
use Project\Shared\Domain\Bus\Command\CommandBusInterface;
use Project\Shared\Domain\Bus\Query\QueryBusInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

readonly class PermissionController
{
    public function __construct(
        private ResponseFactory $response,
        private CommandBusInterface $commandBus,
        private QueryBusInterface $queryBus
    ) { }

    public function index(Request $request): JsonResponse
    {
        return $this->response->json(
            $this->queryBus->ask(
                IndexQuery::makeFromRequest($request)
            )->toResponse()
        );
    }

    public function list(): JsonResponse
    {
        return $this->response->json(
            $this->queryBus->ask(
                new ListQuery()
            )->toResponse()
        );
    }

    public function show(int $id): JsonResponse
    {
        return $this->response->json(
            $this->queryBus->ask(
                new ShowQuery($id)
            )->toResponse()
        );
    }

    public function update(UpdateRequest $request, int $id): Response
    {
        $this->commandBus->dispatch(
            new UpdateCommand(
                $id,
                $request->get('translations'),
                $request->boolean('is_active')
            )
        );

        return $this->response->noContent(Response::HTTP_ACCEPTED);
    }

    public function getPermissionsByRoleUuid(string $uuid): JsonResponse
    {
        return $this->response->json(
            $this->queryBus->ask(
                new GetPermissionsByRoleUuidQuery($uuid)
            )->toResponse()
        );
    }
}