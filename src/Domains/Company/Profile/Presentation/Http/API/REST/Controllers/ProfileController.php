<?php

declare(strict_types=1);

namespace Project\Domains\Company\Profile\Presentation\Http\API\REST\Controllers;

use App\Http\Requests\Api\Admin\Company\Company\Employee\UpdateRequest;
use App\Http\Requests\Api\Company\Profile\ChangePasswordRequest;
use Illuminate\Contracts\Routing\ResponseFactory;
use Project\Domains\Company\Profile\Application\Profile\Commands\Update\Command as UpdateCommand;
use Project\Domains\Company\Profile\Application\Profile\Queries\Show\Query as ShowQuery;
use Project\Domains\Company\Profile\Application\Profile\Commands\ChangePassword\Command as ChangePasswordCommand;
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
                new ShowQuery()
            )
        );
    }

    public function update(UpdateRequest $request): Response
    {
        $this->commandBus->dispatch(
            new UpdateCommand(
                $request->get('company_uuid'),
                $request->get('first_name'),
                $request->get('last_name'),
                $request->get('email'),
                $request->file('avatar')
            )
        );

        return $this->response->noContent(Response::HTTP_ACCEPTED);
    }

    public function changePassword(ChangePasswordRequest $request): Response
    {
        $this->commandBus->dispatch(
            new ChangePasswordCommand(
                $request->headers->get('x-device-id'),
                $request->get('current_password'),
                $request->get('new_password')
            )
        );

        return $this->response->noContent(Response::HTTP_ACCEPTED);
    }
}
