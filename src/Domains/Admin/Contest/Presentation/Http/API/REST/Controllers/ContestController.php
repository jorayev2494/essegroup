<?php

declare(strict_types=1);

namespace Project\Domains\Admin\Contest\Presentation\Http\API\REST\Controllers;

use App\Http\Requests\Api\Admin\Contest\Contest\StoreRequest;
use App\Http\Requests\Api\Admin\Contest\Contest\UpdateRequest;
use Illuminate\Contracts\Routing\ResponseFactory;
use Project\Domains\Admin\Contest\Application\Contest\Commands\Create\Command as CreateCommand;
use Project\Domains\Admin\Contest\Application\Contest\Commands\Delete\Command as DeleteCommand;
use Project\Domains\Admin\Contest\Application\Contest\Commands\Update\Command as UpdateCommand;
use Project\Domains\Admin\Contest\Application\Contest\Queries\Index\Query as IndexQuery;
use Project\Domains\Admin\Contest\Application\Contest\Queries\Participants\Query as ParticipantsQuery;
use Project\Domains\Admin\Contest\Application\Contest\Queries\Show\Query as ShowQuery;
use Project\Infrastructure\Generators\Contracts\UuidGeneratorInterface;
use Project\Shared\Domain\Bus\Command\CommandBusInterface;
use Project\Shared\Domain\Bus\Query\QueryBusInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

readonly class ContestController
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

    public function participants(Request $request): JsonResponse
    {
        return $this->response->json(
            $this->queryBus->ask(
                ParticipantsQuery::makeFromRequest($request)
            )
        );
    }

    public function store(StoreRequest $request): JsonResponse
    {
        $uuid = $this->uuidGenerator->generate();

        $this->commandBus->dispatch(
            new CreateCommand(
                $uuid,
                $request->integer('participants_number'),
                $request->get('translations'),
                $request->get('application_status_uuids', []),
                $request->get('student_nationality_uuids', []),
                $request->get('start_time'),
                $request->boolean('is_active'),
                $request->get('end_time')
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
                $request->integer('participants_number'),
                $request->get('translations'),
                $request->get('application_status_uuids', []),
                $request->get('student_nationality_uuids', []),
                $request->get('start_time'),
                $request->boolean('is_active'),
                $request->get('end_time')
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
