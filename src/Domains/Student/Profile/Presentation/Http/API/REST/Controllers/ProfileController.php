<?php

declare(strict_types=1);

namespace Project\Domains\Student\Profile\Presentation\Http\API\REST\Controllers;

use App\Http\Requests\Api\Student\Profile\UpdateRequest;
use App\Http\Requests\Api\Student\Profile\ChangePasswordRequest;
use Illuminate\Contracts\Routing\ResponseFactory;
use Project\Domains\Student\Profile\Application\Profile\Commands\Update\Command as UpdateCommand;
use Project\Domains\Student\Profile\Application\Profile\Queries\Show\Query as ShowQuery;
use Project\Domains\Student\Profile\Application\Profile\Commands\ChangePassword\Command as ChangePasswordCommand;
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
        ['additional_documents' => $additionalDocuments] = $request->all();

        $this->commandBus->dispatch(
            new UpdateCommand(
                $request->get('first_name'),
                $request->get('last_name'),
                $request->get('birthday'),
                $request->get('passport_number'),
                $request->get('passport_date_of_issue'),
                $request->get('passport_date_of_expiry'),
                $request->get('email'),
                $request->get('phone'),
                $request->get('nationality_uuid'),
                $request->get('country_of_residence_uuid'),
                $request->get('high_school_name'),
                $request->get('high_school_country_uuid'),
                $request->get('high_school_grade_average'),

                $request->file('passport'),
                $request->file('passport_translation'),
                $request->file('school_attestat'),
                $request->file('school_attestat_translation'),
                $request->file('transcript'),
                $request->file('transcript_translation'),
                $request->file('equivalence_document'),
                $request->file('biometric_photo'),
                array_filter($additionalDocuments),

                $request->file('avatar'),
                $request->get('company_uuid'),
                $request->get('communication_language_uuid'),
                $request->get('father_name'),
                $request->get('mother_name'),
                $request->get('friend_phone'),
                $request->get('home_address'),
                $request->get('gender'),
                $request->get('marital_type')
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
