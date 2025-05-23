<?php

declare(strict_types=1);

namespace Project\Domains\Company\Authentication\Presentation\Http\API\REST\Controllers\Restore;

use App\Http\Requests\Api\Company\Authentication\Restore\RestorePasswordLinkRequest;
use Illuminate\Contracts\Routing\ResponseFactory;
use Project\Domains\Company\Authentication\Application\Authentication\Commands\RestorePasswordLink\Command;
use Project\Shared\Domain\Bus\Command\CommandBusInterface;
use Symfony\Component\HttpFoundation\Response;

readonly class RestorePasswordLinkController
{
    function __construct(
        private ResponseFactory $response,
        private CommandBusInterface $commandBus,
    )
    {

    }

    public function __invoke(RestorePasswordLinkRequest $request): Response
    {
        $this->commandBus->dispatch(
            new Command(
                $request->get('email')
            )
        );

        return $this->response->noContent();
    }
}
