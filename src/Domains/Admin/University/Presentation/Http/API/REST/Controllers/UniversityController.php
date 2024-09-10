<?php

declare(strict_types=1);

namespace Project\Domains\Admin\University\Presentation\Http\API\REST\Controllers;

use App\Http\Requests\Api\Admin\University\University\UniversityStoreRequest;
use App\Http\Requests\Api\Admin\University\University\UniversityUpdateRequest;
use Project\Domains\Admin\University\Application\University\Queries\List\Query as ListQuery;
use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Http\Request;
use Project\Domains\Admin\University\Application\University\Commands\Create\Command as CreateCommand;
use Project\Domains\Admin\University\Application\University\Queries\Search\Query as SearchQuery;
use Project\Domains\Admin\University\Application\University\Queries\Show\Query as ShowQuery;
use Project\Domains\Admin\University\Application\University\Commands\Update\Command as UpdateCommand;
use Project\Domains\Admin\University\Application\University\Commands\Delete\Command as DeleteCommand;
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
    ) { }

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

    public function search(Request $request): JsonResponse
    {
        return $this->response->json(
            $this->queryBus->ask(
                SearchQuery::makeFromRequest($request)
            )
        );
    }

    public function store(UniversityStoreRequest $request): JsonResponse
    {
        $uuid = $this->uuidGenerator->generate();

        $this->commandBus->dispatch(
            new CreateCommand(
                $uuid,
                $request->get('country_uuid'),
                $request->get('city_uuid'),
                $request->file('logo'),
                $request->file('cover'),
                $request->get('youtube_video_id'),
                $request->get('translations'),
                $request->boolean('is_on_the_country_list'),
                $request->boolean('is_for_foreign'),
                $request->integer('top_position') ?: null
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

    public function update(UniversityUpdateRequest $request, string $uuid): Response
    {
        $this->commandBus->dispatch(
            new UpdateCommand(
                $uuid,
                $request->get('country_uuid'),
                $request->get('city_uuid'),
                $request->file('logo'),
                $request->file('cover'),
                $request->get('youtube_video_id'),
                $request->get('translations'),
                $request->boolean('is_on_the_country_list'),
                $request->boolean('is_for_foreign'),
                $request->integer('top_position') ?: null
            )
        );

        return $this->response->noContent(Response::HTTP_ACCEPTED);
    }

    public function delete(string $uuid): Response
    {
        $this->commandBus->dispatch(
            new DeleteCommand($uuid)
        );

        return $this->response->noContent(Response::HTTP_ACCEPTED);
    }
}
