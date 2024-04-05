<?php

declare(strict_types=1);

namespace Project\Domains\Admin\University\Presentation\Http\API\REST\Controllers;

use App\Http\Requests\Api\Admin\University\Faculty\FacultyCreateRequest;
use App\Http\Requests\Api\Admin\University\Faculty\FacultyUpdateRequest;
use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Http\Request;
use Project\Domains\Admin\University\Application\Faculty\Commands\Create\Command as StoreCommand;
use Project\Domains\Admin\University\Application\Faculty\Commands\Delete\Command as DeleteCommand;
use Project\Domains\Admin\University\Application\Faculty\Commands\Update\Command as UpdateCommand;
use Project\Domains\Admin\University\Application\Faculty\Queries\Index\Query as IndexQuery;
use Project\Domains\Admin\University\Application\Faculty\Queries\List\Query as ListQuery;
use Project\Domains\Admin\University\Application\Faculty\Queries\Show\Query as ShowQuery;
use Project\Infrastructure\Generators\Contracts\UuidGeneratorInterface;
use Project\Shared\Domain\Bus\Command\CommandBusInterface;
use Project\Shared\Domain\Bus\Query\QueryBusInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

readonly class FacultyController
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

    public function store(FacultyCreateRequest $request): JsonResponse
    {
        $uuid = $this->uuidGenerator->generate();

        $this->commandBus->dispatch(
            new StoreCommand(
                $uuid,
                $request->get('name_uuid'),
                $request->get('university_uuid'),
                $request->file('logo'),
                $request->get('translations'),
                $request->boolean('is_active', true)
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

    public function update(FacultyUpdateRequest $request, string $uuid): Response
    {
        $this->commandBus->dispatch(
            new UpdateCommand(
                $uuid,
                $request->get('name_uuid'),
                $request->get('university_uuid'),
                $request->file('logo'),
                $request->get('translations'),
                $request->boolean('is_active', true)
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
