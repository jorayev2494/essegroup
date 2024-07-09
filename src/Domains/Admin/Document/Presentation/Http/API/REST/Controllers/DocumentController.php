<?php

declare(strict_types=1);

namespace Project\Domains\Admin\Document\Presentation\Http\API\REST\Controllers;

use Illuminate\Contracts\Routing\ResponseFactory;
use Project\Domains\Admin\Document\Application\Document\Queries\Index\Query as IndexQuery;
use Project\Domains\Admin\Document\Application\Document\Queries\List\Query as ListQuery;
use Project\Domains\Admin\Document\Application\Document\Commands\Create\Command as CreateCommand;
use Project\Domains\Admin\Document\Application\Document\Queries\Download\Query as DownloadQuery;
use Project\Domains\Admin\Document\Application\Document\Queries\Show\Query as ShowQuery;
use Project\Domains\Admin\Document\Application\Document\Commands\Update\Command as UpdateCommand;
use Project\Domains\Admin\Document\Application\Document\Commands\Delete\Command as DeleteCommand;
use Project\Domains\Admin\Document\Domain\Document\ValueObjects\TypeEnum;
use Project\Infrastructure\Generators\Contracts\UuidGeneratorInterface;
use Project\Shared\Domain\Bus\Command\CommandBusInterface;
use App\Http\Requests\Api\Admin\Document\StoreRequest;
use App\Http\Requests\Api\Admin\Document\UpdateRequest;
use Project\Shared\Domain\Bus\Query\QueryBusInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\StreamedResponse;

readonly class DocumentController
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

    public function types(): JsonResponse
    {
        return $this->response->json(
            array_map(
                static fn (TypeEnum $type): array => [
                    'value' => $type->value,
                ],
                TypeEnum::cases()
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
                $request->get('type'),
                $request->file('file'),
                $request->get('translations'),
                $request->boolean('is_active')
            )
        );

        return $this->response->json(['uuid' => $uuid],Response::HTTP_CREATED);
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
                $request->get('type'),
                $request->get('translations'),
                $request->boolean('is_active'),
                $request->file('file')
            )
        );

        return $this->response->noContent(Response::HTTP_ACCEPTED);
    }

    public function download(string $uuid): StreamedResponse
    {
        return $this->queryBus->ask(
            new DownloadQuery($uuid)
        );
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
