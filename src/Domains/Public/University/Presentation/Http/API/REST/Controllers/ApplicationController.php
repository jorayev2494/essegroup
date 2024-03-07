<?php

declare(strict_types=1);

namespace Project\Domains\Public\University\Presentation\Http\API\REST\Controllers;

use App\Http\Requests\Api\Public\University\Application\ApplicationStoreRequest;
use Illuminate\Contracts\Routing\ResponseFactory;
use Project\Domains\Admin\University\Application\Application\Commands\Create\Command as CreateCommand;
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
    )
    {

    }

    public function store(ApplicationStoreRequest $request): JsonResponse
    {
        $uuid = $this->uuidGenerator->generate();

        ['additional_documents' => $additionalDocuments] = $request->all();

        $this->commandBus->dispatch(
            new CreateCommand(
                $uuid,
                $request->get('full_name'),
                $request->get('birthday'),
                $request->get('passport_number'),
                $request->get('email'),
                $request->get('phone'),
                $request->get('university_uuid'),
                $request->get('department_uuids'),
                $request->get('country_uuid'),
                $request->file('passport'),
                $request->file('passport_translation'),
                $request->file('school_attestat'),
                $request->file('school_attestat_translation'),
                $request->file('transcript'),
                $request->file('transcript_translation'),
                $request->file('equivalence_document'),
                $request->file('biometric_photo'),
                $additionalDocuments,
                $request->boolean('is_agreed_to_share_data'),
                'client',
                $request->get('company_uuid'),
                $request->get('father_name'),
                $request->get('mother_name'),
                $request->get('friend_phone'),
                $request->get('home_address'),
            )
        );

        return $this->response->json(['uuid' => $uuid], Response::HTTP_ACCEPTED);
    }
}
