<?php

declare(strict_types=1);

namespace Project\Domains\Admin\Authentication\Presentation\Http\API\REST\Controllers\Restore;

use App\Http\Requests\Api\Admin\Authentication\Restore\RestorePasswordRequest;
use Illuminate\Contracts\Routing\ResponseFactory;
use Project\Domains\Admin\Authentication\Application\Commands\RestorePassword\Command;
use Project\Shared\Domain\Bus\Command\CommandBusInterface;
use Symfony\Component\HttpFoundation\Response;

readonly class RestorePasswordController
{
    function __construct(
        private ResponseFactory $response,
        private CommandBusInterface $commandBus,
    )
    {

    }

    public function __invoke(RestorePasswordRequest $request): Response
    {
        $this->commandBus->dispatch(
            new Command(
                $request->get('token'),
                $request->get('password')
            )
        );

        return $this->response->noContent();
    }
}
