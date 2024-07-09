<?php

declare(strict_types=1);

namespace Project\Domains\Admin\Currency\Presentation\Http\API\REST\Controllers;

use App\Http\Requests\Api\Admin\Currency\Currency\StoreRequest;
use Illuminate\Contracts\Routing\ResponseFactory;
use Project\Domains\Admin\Currency\Application\Currency\Queries\List\Query as ListQuery;
use Project\Domains\Admin\Currency\Application\Currency\Commands\Create\Command as CreateCommand;
use Project\Infrastructure\Generators\Contracts\UuidGeneratorInterface;
use Project\Shared\Domain\Bus\Command\CommandBusInterface;
use Project\Shared\Domain\Bus\Query\QueryBusInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

readonly class CurrencyController
{
    public function __construct(
        private ResponseFactory $response,
        private UuidGeneratorInterface $uuidGenerator,
        private CommandBusInterface $commandBus,
        private QueryBusInterface $queryBus
    ) { }

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
                $request->get('value'),
                $request->get('code'),
                $request->get('symbol'),
                $request->boolean('is_active'),
                $request->get('description')
            )
        );

        return $this->response->json(['uuid' => $uuid], Response::HTTP_CREATED);
    }
}
