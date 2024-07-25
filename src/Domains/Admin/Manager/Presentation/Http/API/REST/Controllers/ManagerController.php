<?php

declare(strict_types=1);

namespace Project\Domains\Admin\Manager\Presentation\Http\API\REST\Controllers;

use App\Http\Requests\Api\Admin\Manager\Manager\StoreRequest;
use App\Http\Requests\Api\Admin\Manager\Manager\UpdateRequest;
use Illuminate\Contracts\Routing\ResponseFactory;
use Project\Domains\Admin\Manager\Application\Manager\Queries\Index\Query as IndexQuery;
use Project\Domains\Admin\Manager\Application\Manager\Commands\Create\Command as CreateCommand;
use Project\Domains\Admin\Manager\Application\Manager\Queries\Show\Query as ShowQuery;
use Project\Domains\Admin\Manager\Application\Manager\Commands\Update\Command as UpdateCommand;
use Project\Domains\Admin\Manager\Application\Manager\Commands\Delete\Command as DeleteCommand;
use Project\Infrastructure\Generators\Contracts\UuidGeneratorInterface;
use Project\Shared\Domain\Bus\Command\CommandBusInterface;
use Project\Shared\Domain\Bus\Query\QueryBusInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

readonly class ManagerController
{
    public function __construct(
        private ResponseFactory $response,
        private UuidGeneratorInterface $uuidGenerator,
        private CommandBusInterface $commandBus,
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

    public function store(StoreRequest $request): JsonResponse
    {
        $uuid = $this->uuidGenerator->generate();

        $this->commandBus->dispatch(
            new CreateCommand(
                $uuid,
                $request->get('first_name'),
                $request->get('last_name'),
                $request->file('avatar'),
                $request->get('email'),
                $request->get('role_uuid')
            )
        );

        return $this->response->json(['uuid' => $uuid], Response::HTTP_CREATED);
    }

    public function show(string $uuid): JsonResponse
    {
        return $this->response->json(
            $this->queryBus->ask(
                new ShowQuery($uuid)
            )
        );
    }

    public function update(UpdateRequest $request, string $uuid): Response
    {
        $this->commandBus->dispatch(
            new UpdateCommand(
                $uuid,
                $request->get('first_name'),
                $request->get('last_name'),
                $request->file('avatar'),
                $request->get('email'),
                $request->get('role_uuid')
            )
        );

        return $this->response->noContent(Response::HTTP_ACCEPTED);
    }

    public function delete(string $uuid): Response
    {
        $this->commandBus->dispatch(
            new DeleteCommand(
                $uuid
            )
        );

        return $this->response->noContent();
    }
}
