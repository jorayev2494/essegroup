<?php

declare(strict_types=1);

namespace Project\Domains\Admin\University\Presentation\Http\API\REST\Controllers;

use App\Http\Requests\Api\Admin\University\University\UniversityStoreRequest;
use App\Http\Requests\Api\Admin\University\University\UniversityUpdateRequest;
use Project\Domains\Admin\University\Application\University\Queries\List\Query as ListQuery;
use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Http\Request;
use Project\Domains\Admin\University\Application\University\Commands\Create\Command;
use Project\Domains\Admin\University\Application\University\Queries\Show\Query;
use Project\Infrastructure\Generators\Contracts\UuidGeneratorInterface;
use Project\Shared\Domain\Bus\Command\CommandBusInterface;
use Project\Shared\Domain\Bus\Query\QueryBusInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

readonly class UniversityController
{
    public function __construct(
        private ResponseFactory $response,
        private UuidGeneratorInterface $uuidGenerator,
        private CommandBusInterface $commandBus,
        private QueryBusInterface $queryBus,
    )
    {

    }

    public function index(Request $request): JsonResponse
    {
        return $this->response->json(
            $this->queryBus->ask(
                \Project\Domains\Admin\University\Application\University\Queries\Index\Query::makeFromRequest($request)
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

    public function store(UniversityStoreRequest $request): JsonResponse
    {
        $uuid = $this->uuidGenerator->generate();

        $this->commandBus->dispatch(
            new Command(
                $uuid,
                $request->file('logo'),
                $request->file('cover'),
                $request->get('youtube_video_id'),
                $request->get('translations'),
            )
        );

        return $this->response->json(['uuid' => $uuid], Response::HTTP_CREATED);
    }

    public function show(string $uuid): JsonResponse
    {
        return $this->response->json(
            $this->queryBus->ask(
                new Query($uuid)
            )
        );
    }

    public function update(UniversityUpdateRequest $request, string $uuid): Response
    {
        $this->commandBus->dispatch(
            new \Project\Domains\Admin\University\Application\University\Commands\Update\Command(
                $uuid,
                $request->file('logo'),
                $request->file('cover'),
                $request->get('youtube_video_id'),
                $request->get('translations'),
            )
        );

        return $this->response->noContent(Response::HTTP_ACCEPTED);
    }

    public function delete(string $uuid): Response
    {
        $this->commandBus->dispatch(
            new \Project\Domains\Admin\University\Application\University\Commands\Delete\Command(
                $uuid,
            )
        );

        return $this->response->noContent(Response::HTTP_ACCEPTED);
    }
}
