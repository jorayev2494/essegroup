<?php

declare(strict_types=1);

namespace Project\Domains\Company\Profile\Presentation\Http\API\REST\Controllers;

use App\Http\Requests\Api\Admin\Company\Company\Employee\UpdateRequest;
use Illuminate\Contracts\Routing\ResponseFactory;
use Project\Domains\Company\Profile\Application\Profile\Commands\Update\Command;
use Project\Domains\Company\Profile\Application\Profile\Queries\Show\Query;
use Project\Shared\Domain\Bus\Command\CommandBusInterface;
use Project\Shared\Domain\Bus\Query\QueryBusInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

readonly class ProfileController
{
    public function __construct(
        private ResponseFactory $response,
        private QueryBusInterface $queryBus,
        private CommandBusInterface $commandBus
    ) { }

    public function show(): JsonResponse
    {
        return $this->response->json(
            $this->queryBus->ask(
                new Query()
            )
        );
    }

    public function update(UpdateRequest $request): Response
    {
        $this->commandBus->dispatch(
            new Command(
                $request->get('first_name'),
                $request->get('last_name'),
                $request->get('email'),
                $request->file('avatar')
            )
        );

        return $this->response->noContent(Response::HTTP_ACCEPTED);
    }
}
