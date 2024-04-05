<?php

declare(strict_types=1);

namespace Project\Domains\Admin\University\Presentation\Http\API\REST\Controllers;

use App\Http\Requests\Api\Admin\University\Department\Name\StoreRequest;
use App\Http\Requests\Api\Admin\University\Department\Name\UpdateRequest;
use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Http\Request;
use Project\Domains\Admin\University\Application\DepartmentName\Queries\Index\Query as IndexQuery;
use Project\Domains\Admin\University\Application\DepartmentName\Queries\List\Query as ListQuery;
use Project\Domains\Admin\University\Application\DepartmentName\Commands\Create\Command as CreateCommand;
use Project\Domains\Admin\University\Application\DepartmentName\Queries\Show\Query as ShowQuery;
use Project\Domains\Admin\University\Application\DepartmentName\Commands\Update\Command as UpdateCommand;
use Project\Domains\Admin\University\Application\DepartmentName\Commands\Delete\Command as DeleteCommand;
use Project\Infrastructure\Generators\Contracts\UuidGeneratorInterface;
use Project\Shared\Domain\Bus\Command\CommandBusInterface;
use Project\Shared\Domain\Bus\Query\QueryBusInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

readonly class DepartmentNameController
{
    public function __construct(
        private ResponseFactory $response,
        private UuidGeneratorInterface $uuidGenerator,
        private CommandBusInterface $commandBus,
        private QueryBusInterface $queryBus
    ) {

    }

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

    public function store(StoreRequest $request): JsonResponse
    {
        $uuid = $this->uuidGenerator->generate();

        $this->commandBus->dispatch(
            new CreateCommand(
                $uuid,
                $request->get('translations'),
                true
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
                $request->get('translations'),
                true
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
