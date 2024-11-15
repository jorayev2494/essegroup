<?php

declare(strict_types=1);

namespace Project\Domains\Admin\Country\Presentation\Http\API\REST\Controllers;

use App\Http\Requests\Api\Admin\Country\CreateCountryRequest;
use App\Http\Requests\Api\Admin\Country\UpdateCountryRequest;
use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Http\Request;
use Project\Domains\Admin\Country\Application\Country\Commands\Create\Command as CreateCommand;
use Project\Domains\Admin\Country\Application\Country\Commands\Delete\Command as DeleteCommand;
use Project\Domains\Admin\Country\Application\Country\Commands\Update\Command as UpdateCommand;
use Project\Domains\Admin\Country\Application\Country\Queries\List\Query as QueriesList;
use Project\Domains\Admin\Country\Application\Country\Queries\Index\Query as IndexQuery;
use Project\Domains\Admin\Country\Application\Country\Queries\Show\Query as QueriesShow;
use Project\Infrastructure\Generators\Contracts\UuidGeneratorInterface;
use Project\Shared\Domain\Bus\Command\CommandBusInterface;
use Project\Shared\Domain\Bus\Query\QueryBusInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

readonly class CountryController
{
    public function __construct(
        private ResponseFactory $response,
        private UuidGeneratorInterface $uuidGenerator,
        private QueryBusInterface $queryBus,
        private CommandBusInterface $commandBus
    )
    {

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
                QueriesList::makeFromRequest($request)
            )
        );
    }

    public function show(string $uuid): JsonResponse
    {
        return $this->response->json(
            $this->queryBus->ask(
                new QueriesShow($uuid)
            )
        );
    }

    public function store(CreateCountryRequest $request): JsonResponse
    {
        $uuid = $this->uuidGenerator->generate();

        $this->commandBus->dispatch(
            new CreateCommand(
                $uuid,
                $request->get('iso'),
                $request->get('translations'),
                $request->get('is_active'),
            )
        );

        return $this->response->json(['uuid' => $uuid], Response::HTTP_CREATED);
    }

    public function update(UpdateCountryRequest $request, string $uuid): Response
    {
        $this->commandBus->dispatch(
            new UpdateCommand(
                $uuid,
                $request->get('iso'),
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
