<?php

declare(strict_types=1);

namespace Project\Domains\Admin\Manager\Presentation\Http\API\REST\Controllers;

use App\Http\Requests\Api\Admin\Manager\Manager\StoreRequest;
use Illuminate\Contracts\Routing\ResponseFactory;
use Project\Infrastructure\Generators\Contracts\UuidGeneratorInterface;
use Project\Shared\Domain\Bus\Command\CommandBusInterface;
use Project\Shared\Domain\Bus\Query\QueryBusInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

readonly class ManagerController
{
    public function __construct(
        private ResponseFactory $response,
        private UuidGeneratorInterface $uuidGenerator,
        private CommandBusInterface $commandBus,
        private QueryBusInterface $queryBus
    ) { }

    public function store(StoreRequest $request): JsonResponse
    {
        $uuid = $this->uuidGenerator->generate();

        return $this->response->json(['uuid' => $uuid], Response::HTTP_CREATED);
    }
}
