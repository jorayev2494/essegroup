<?php

declare(strict_types=1);

namespace Project\Domains\Admin\Company\Presentation\Http\API\REST\Controllers;

use App\Http\Requests\Api\Admin\Company\Company\Employee\StoreRequest;
use App\Http\Requests\Api\Admin\Company\Company\Employee\UpdateRequest;
use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Http\Request;
use Project\Domains\Admin\Company\Application\Employee\Commands\Create\Command as CreateCommand;
use Project\Domains\Admin\Company\Application\Employee\Commands\Delete\Command as DeleteCommand;
use Project\Domains\Admin\Company\Application\Employee\Commands\Update\Command as UpdateCommand;
use Project\Domains\Admin\Company\Application\Employee\Queries\Index\Query;
use Project\Domains\Admin\Company\Application\Employee\Queries\Show\Query as ShowQuery;
use Project\Infrastructure\Generators\Contracts\UuidGeneratorInterface;
use Project\Shared\Domain\Bus\Command\CommandBusInterface;
use Project\Shared\Domain\Bus\Query\QueryBusInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

readonly class EmployeeController
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
                Query::makeFromRequest($request)
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
                $request->get('email'),
                $request->file('avatar'),
                $request->get('company_uuid'),
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
                $request->get('email'),
                $request->file('avatar')
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