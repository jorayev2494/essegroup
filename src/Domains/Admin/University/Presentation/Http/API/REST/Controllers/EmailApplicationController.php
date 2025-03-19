<?php

declare(strict_types=1);

namespace Project\Domains\Admin\University\Presentation\Http\API\REST\Controllers;

use App\Http\Requests\Api\Admin\EmailApplication\StoreRequest;
use Illuminate\Contracts\Routing\ResponseFactory;
use Project\Infrastructure\Generators\Contracts\UuidGeneratorInterface;
use Project\Shared\Domain\Bus\Command\CommandBusInterface;
use Symfony\Component\HttpFoundation\Response;
use Project\Domains\Admin\University\Application\EmailApplication\Commands\EmailApplication\Command as EmailApplicationCommand;

readonly class EmailApplicationController
{
    public function __construct(
        private ResponseFactory $response,
        private UuidGeneratorInterface $uuidGenerator,
        private CommandBusInterface $commandBus
    ) { }

    public function store(StoreRequest $request): Response
    {
        $this->commandBus->dispatch(
            new EmailApplicationCommand(
                $this->uuidGenerator->generate(),
                $request->get('first_name'),
                $request->get('last_name'),
                $request->get('father_first_name'),
                $request->get('mother_first_name'),
                $request->get('phone'),
                $request->get('additional_phone'),
                $request->get('note'),
            )
        );

        return $this->response->noContent(Response::HTTP_ACCEPTED);
    }
}