<?php

declare(strict_types=1);

namespace Project\Domains\Public\Student\Presentation\Http\API\REST\Controllers;

use App\Http\Requests\Api\Public\Student\Student\StoreRequest;
use Illuminate\Contracts\Routing\ResponseFactory;
use Project\Domains\Public\Student\Application\Commands\Create\Command;
use Project\Infrastructure\Generators\Contracts\UuidGeneratorInterface;
use Project\Shared\Domain\Bus\Command\CommandBusInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

readonly class StudentController
{
    public function __construct(
        private ResponseFactory $response,
        private UuidGeneratorInterface $uuidGenerator,
        private CommandBusInterface $commandBus
    ) { }

    public function store(StoreRequest $request): JsonResponse
    {
        $uuid = $this->uuidGenerator->generate();
        ['additional_documents' => $additionalDocuments] = $request->all();

        $this->commandBus->dispatch(
            new Command(
                $uuid,
                $request->get('first_name'),
                $request->get('last_name'),
                $request->file('avatar'),
                $request->get('birthday'),
                $request->get('passport_number'),
                $request->get('email'),
                $request->get('phone'),
                $request->get('nationality_uuid'),
                $request->get('country_of_residence_uuid'),
                $request->get('high_school_country_uuid'),

                'client',
                $request->file('passport'),
                $request->file('passport_translation'),
                $request->file('school_attestat'),
                $request->file('school_attestat_translation'),
                $request->file('transcript'),
                $request->file('transcript_translation'),
                $request->file('equivalence_document'),
                $request->file('biometric_photo'),
                array_filter($additionalDocuments),

                $request->get('company_uuid'),
                $request->get('communication_language_uuid'),
                $request->get('father_name'),
                $request->get('mother_name'),
                $request->get('friend_phone'),
                $request->get('home_address'),
                $request->get('gender'),
                $request->get('marital_type'),
                $request->get('passport_date_of_issue'),
                $request->get('passport_date_of_expiry'),
                $request->get('high_school_name'),
                $request->get('high_school_grade_average')
            )
        );

        return $this->response->json(['uuid' => $uuid], Response::HTTP_CREATED);
    }
}
