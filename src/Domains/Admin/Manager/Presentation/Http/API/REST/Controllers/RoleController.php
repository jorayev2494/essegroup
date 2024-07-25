<?php

declare(strict_types=1);

namespace Project\Domains\Admin\Manager\Presentation\Http\API\REST\Controllers;

use App\Http\Requests\Api\Admin\Manager\Role\Permission\UpdatePermissionsRequest;
use App\Http\Requests\Api\Admin\Manager\Role\StoreRequest;
use App\Http\Requests\Api\Admin\Manager\Role\UpdateRequest;
use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Http\Request;
use Project\Domains\Admin\Manager\Application\Role\Queries\Index\Query as IndexQuery;
use Project\Domains\Admin\Manager\Application\Role\Queries\List\Query as ListQuery;
use Project\Domains\Admin\Manager\Application\Role\Commands\Create\Command as CreateCommand;
use Project\Domains\Admin\Manager\Application\Role\Queries\Show\Query as ShowQuery;
use Project\Domains\Admin\Manager\Application\Role\Commands\Update\Command as UpdateCommand;
use Project\Domains\Admin\Manager\Application\Role\Commands\UpdatePermissions\Command as UpdatePermissionsCommand;
use Project\Domains\Admin\Manager\Application\Role\Commands\Delete\Command as DeleteCommand;
use Project\Infrastructure\Generators\Contracts\UuidGeneratorInterface;
use Project\Shared\Domain\Bus\Command\CommandBusInterface;
use Project\Shared\Domain\Bus\Query\QueryBusInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

readonly class RoleController
{
    public function __construct(
        private ResponseFactory $response,
        private CommandBusInterface $commandBus,
        private QueryBusInterface $queryBus,
        private UuidGeneratorInterface $uuidGenerator
    ) { }

    public function index(Request $request): JsonResponse
    {
        $output = $this->queryBus->ask(IndexQuery::makeFromRequest($request));

        return $this->response->json($output->toResponse());
    }

    public function list(): JsonResponse
    {
        $output = $this->queryBus->ask(new ListQuery());

        return $this->response->json($output->toResponse());
    }

    public function store(StoreRequest $request): JsonResponse
    {
        $uuid = $this->uuidGenerator->generate();

        $this->commandBus->dispatch(
            new CreateCommand(
                $uuid,
                $request->get('translations'),
                $request->boolean('is_active')
            )
        );

        return $this->response->json(['uuid' => $uuid], Response::HTTP_CREATED);
    }

    public function show(string $uuid): JsonResponse
    {
        $output = $this->queryBus->ask(new ShowQuery($uuid));

        return $this->response->json($output->toResponse());
    }

    public function update(UpdateRequest $request, string $uuid): Response
    {
        $this->commandBus->dispatch(
            new UpdateCommand(
                $uuid,
                $request->get('translations'),
                $request->get('is_active')
            )
        );

        return $this->response->noContent(Response::HTTP_ACCEPTED);
    }

    public function updatePermissions(UpdatePermissionsRequest $request, string $uuid): Response
    {
        $this->commandBus->dispatch(
            new UpdatePermissionsCommand(
                $uuid,
                $request->get('permission_ids')
            )
        );

        return $this->response->noContent(Response::HTTP_ACCEPTED);
    }

    public function delete(string $uuid): Response
    {
        $this->commandBus->dispatch(
            new DeleteCommand($uuid)
        );

        return $this->response->noContent();
    }
}