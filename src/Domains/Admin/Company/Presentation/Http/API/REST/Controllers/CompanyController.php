<?php

declare(strict_types=1);

namespace Project\Domains\Admin\Company\Presentation\Http\API\REST\Controllers;

use App\Http\Requests\Api\Admin\Company\Company\CompanyStoreRequest;
use App\Http\Requests\Api\Admin\Company\Company\CompanyUpdateRequest;
use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Http\Request;
use Project\Domains\Admin\Company\Application\Company\Commands\Create\Command;
use Project\Domains\Admin\Company\Application\Company\Queries\Index\Query;
use Project\Domains\Admin\Company\Application\Company\Queries\List\Query as ListQuery;
use Project\Infrastructure\Generators\Contracts\UuidGeneratorInterface;
use Project\Shared\Domain\Bus\Command\CommandBusInterface;
use Project\Shared\Domain\Bus\Query\QueryBusInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

readonly class CompanyController
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
                Query::makeFromRequest($request)
            )
        );
    }

    public function list(Request $request): JsonResponse
    {
        return $this->response->json(
            $this->queryBus->ask(
                new ListQuery()
            )
        );
    }

    public function store(CompanyStoreRequest $request): JsonResponse
    {
        $uuid = $this->uuidGenerator->generate();

        $this->commandBus->dispatch(
            new Command(
                $uuid,
                $request->file('logo'),
                $request->get('name'),
                $request->get('email'),
                $request->get('domain'),
            )
        );

        return $this->response->json(['uuid' => $uuid], Response::HTTP_CREATED);
    }

    public function show(string $uuid): JsonResponse
    {
        return $this->response->json(
            $this->queryBus->ask(
                new \Project\Domains\Admin\Company\Application\Company\Queries\Show\Query(
                    $uuid
                )
            )
        );
    }

    public function update(CompanyUpdateRequest $request, string $uuid): Response
    {
        $this->commandBus->dispatch(
            new \Project\Domains\Admin\Company\Application\Company\Commands\Update\Command(
                $uuid,
                $request->file('logo'),
                $request->get('name'),
                $request->get('email'),
                $request->get('domain'),
            )
        );
        return $this->response->noContent(Response::HTTP_ACCEPTED);
    }

    public function delete(string $uuid): Response
    {
        $this->commandBus->dispatch(
            new \Project\Domains\Admin\Company\Application\Company\Commands\Delete\Command(
                $uuid
            )
        );
        return $this->response->noContent();
    }
}
