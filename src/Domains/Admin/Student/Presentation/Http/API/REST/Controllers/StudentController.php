<?php

declare(strict_types=1);

namespace Project\Domains\Admin\Student\Presentation\Http\API\REST\Controllers;

use App\Http\Requests\Api\Admin\Student\Student\StoreRequest;
use App\Http\Requests\Api\Admin\Student\Student\UpdateRequest;
use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Http\Request;
use \Project\Domains\Admin\Student\Application\Queries\Index\Query as IndexQuery;
use Project\Domains\Admin\Student\Application\Commands\Create\Command as CreateCommand;
use Project\Domains\Admin\Student\Application\Queries\Show\Query as ShowQuery;
use Project\Domains\Admin\Student\Application\Commands\Update\Command as UpdateCommand;
use Project\Domains\Admin\Student\Application\Commands\Delete\Command as DeleteCommand;
use Project\Infrastructure\Generators\Contracts\UuidGeneratorInterface;
use Project\Shared\Domain\Bus\Command\CommandBusInterface;
use Project\Shared\Domain\Bus\Query\QueryBusInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

readonly class StudentController
{
    public function __construct(
        private ResponseFactory $response,
        private UuidGeneratorInterface $uuidGenerator,
        private CommandBusInterface $commandBus,
        private QueryBusInterface $queryBus
    ) { }

    public function index(Request $request): JsonResponse
    {
        return $this->response->json(
            $this->queryBus->ask(
                IndexQuery::makeFromRequest($request)
            )
        );
    }

    public function store(StoreRequest $request): JsonResponse
    {
        $uuid = $this->uuidGenerator->generate();
        ['additional_documents' => $additionalDocuments] = $request->all();

        $this->commandBus->dispatch(
            new CreateCommand(
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

                'admin',
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

    public function show(string $uuid): JsonResponse
    {
        return $this->response->json(
            $this->queryBus->ask(
                new ShowQuery($uuid)
            )
        );
    }

    public function update(UpdateRequest $request, string $uuid): Response
    {
        ['additional_documents' => $additionalDocuments] = $request->all();

        $this->commandBus->dispatch(
            new UpdateCommand(
                $uuid,
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

    public function delete(string $uuid): Response
    {
        $this->commandBus->dispatch(
            new DeleteCommand(
                $uuid
            )
        );

        return $this->response->noContent();
    }
}
