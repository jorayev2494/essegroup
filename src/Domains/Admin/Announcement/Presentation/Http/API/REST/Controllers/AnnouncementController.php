<?php

declare(strict_types=1);

namespace Project\Domains\Admin\Announcement\Presentation\Http\API\REST\Controllers;

use App\Http\Requests\Api\Admin\Announcement\Announcement\StoreRequest;
use App\Http\Requests\Api\Admin\Announcement\Announcement\UpdateRequest;
use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Http\Request;
use Project\Domains\Admin\Announcement\Application\Announcement\Queries\Index\Query as IndexQuery;
use Project\Domains\Admin\Announcement\Application\Announcement\Queries\List\Query as ListQuery;
use Project\Domains\Admin\Announcement\Application\Announcement\Commands\Create\Command as CreateCommand;
use Project\Domains\Admin\Announcement\Application\Announcement\Queries\Show\Query as ShowQuery;
use Project\Domains\Admin\Announcement\Application\Announcement\Queries\View\Query as ViewQuery;
use Project\Domains\Admin\Announcement\Application\Announcement\Commands\Update\Command as UpdateCommand;
use Project\Domains\Admin\Announcement\Application\Announcement\Commands\Delete\Command as DeleteCommand;
use Project\Infrastructure\Generators\Contracts\UuidGeneratorInterface;
use Project\Shared\Domain\Bus\Command\CommandBusInterface;
use Project\Shared\Domain\Bus\Query\QueryBusInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

readonly class AnnouncementController
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
                $request->get('for'),
                $request->get('start_time'),
                $request->get('end_time'),
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
                new ShowQuery($uuid)
            )
        );
    }

    public function view(string $uuid): JsonResponse
    {
        return $this->response->json(
            $this->queryBus->ask(
                new ViewQuery($uuid)
            )
        );
    }

    public function update(UpdateRequest $request, string $uuid): Response
    {
        $this->commandBus->dispatch(
            new UpdateCommand(
                $uuid,
                $request->get('for'),
                $request->get('start_time'),
                $request->get('end_time'),
                $request->get('translations'),
                $request->boolean('is_active')
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
