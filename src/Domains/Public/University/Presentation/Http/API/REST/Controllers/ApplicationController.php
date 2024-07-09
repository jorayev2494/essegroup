<?php

declare(strict_types=1);

namespace Project\Domains\Public\University\Presentation\Http\API\REST\Controllers;

use App\Http\Requests\Api\Public\University\Application\ApplicationStoreRequest;
use Illuminate\Contracts\Routing\ResponseFactory;
use Project\Domains\Public\University\Application\Application\Commands\Create\Command as CreateCommand;
use Project\Infrastructure\Generators\Contracts\UuidGeneratorInterface;
use Project\Shared\Domain\Bus\Command\CommandBusInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

readonly class ApplicationController
{
    public function __construct(
        private ResponseFactory $response,
        private UuidGeneratorInterface $uuidGenerator,
        private CommandBusInterface $commandBus
    ) { }

    public function store(ApplicationStoreRequest $request): JsonResponse
    {
        $uuid = $this->uuidGenerator->generate();

        $this->commandBus->dispatch(
            new CreateCommand(
                $uuid,
                $request->get('student_uuid'),
                $request->get('language_uuid'),
                $request->get('degree_uuid'),
                $request->get('university_uuid'),
                $request->get('department_uuids'),
                $request->boolean('is_agreed_to_share_data'),
                $request->get('alias_uuid'),
                $request->get('country_uuid'),
            )
        );

        return $this->response->json(['uuid' => $uuid], Response::HTTP_ACCEPTED);
    }
}
