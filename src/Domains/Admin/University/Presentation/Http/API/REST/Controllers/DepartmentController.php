<?php

declare(strict_types=1);

namespace Project\Domains\Admin\University\Presentation\Http\API\REST\Controllers;

use App\Http\Requests\Api\Admin\University\Department\DepartmentStoreRequest;
use App\Http\Requests\Api\Admin\University\Department\DepartmentUpdateRequest;
use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Http\Request;
use Project\Domains\Admin\University\Application\Department\Commands\Delete\Command;
use Project\Domains\Admin\University\Application\Department\Commands\Update\Command as UpdateCommand;
use Project\Domains\Admin\University\Application\Department\Queries\Index\Query as IndexQuery;
use Project\Domains\Admin\University\Application\Department\Commands\Create\Command as CreateCommand;
use Project\Domains\Admin\University\Application\Department\Queries\List\Query as ListQuery;
use Project\Domains\Admin\University\Application\Department\Queries\Show\Query;
use Project\Infrastructure\Generators\Contracts\UuidGeneratorInterface;
use Project\Shared\Domain\Bus\Command\CommandBusInterface;
use Project\Shared\Domain\Bus\Query\QueryBusInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

readonly class DepartmentController
{
    public function __construct(
        private ResponseFactory $response,
        private UuidGeneratorInterface $uuidGenerator,
        private QueryBusInterface $queryBus,
        private CommandBusInterface $commandBus
    )
    {

    }

    public function list(Request $request): JsonResponse
    {
        return $this->response->json(
            $this->queryBus->ask(
                ListQuery::makeFromRequest($request)
            )
        );
    }

    public function index(Request $request): JsonResponse
    {
        return $this->response->json(
            $this->queryBus->ask(
                IndexQuery::makeFromRequest($request)
            )
        );
    }

    public function store(DepartmentStoreRequest $request): JsonResponse
    {
        $uuid = $this->uuidGenerator->generate();

        $this->commandBus->dispatch(
            new CreateCommand(
                $uuid,
                $request->get('company_uuid'),
                $request->get('faculty_uuid'),
                $request->get('translations'),
                $request->boolean('is_active')
            )
        );

        return $this->response->json(['uuid' => $uuid]);
    }

    public function show(string $uuid): JsonResponse
    {
        return $this->response->json(
            $this->queryBus->ask(
                new Query($uuid)
            )
        );
    }

    public function update(DepartmentUpdateRequest $request, string $uuid): Response
    {
        $this->commandBus->dispatch(
            new UpdateCommand(
                $uuid,
                $request->get('company_uuid'),
                $request->get('faculty_uuid'),
                $request->get('translations'),
                $request->boolean('is_active')
            )
        );

        return $this->response->noContent(Response::HTTP_ACCEPTED);
    }

    public function delete(string $uuid): Response
    {
        $this->commandBus->dispatch(
            new Command(
                $uuid
            )
        );

        return $this->response->noContent();
    }
}
