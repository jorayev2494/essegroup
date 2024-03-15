<?php

declare(strict_types=1);

namespace Project\Domains\Admin\University\Presentation\Http\API\REST\Controllers;

use App\Http\Requests\Api\Admin\University\Application\ApplicationStoreRequest;
use App\Http\Requests\Api\Admin\University\Application\ApplicationUpdateRequest;
use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Http\Request;
use Project\Domains\Admin\University\Application\Application\Commands\Create\Command as CreateCommand;
use Project\Domains\Admin\University\Application\Application\Commands\Delete\Command as DeleteCommand;
use Project\Domains\Admin\University\Application\Application\Commands\Update\Command as UpdateCommand;
use Project\Domains\Admin\University\Application\Application\Queries\Index\Query as IndexQuery;
use Project\Domains\Admin\University\Application\Application\Queries\Show\Query as ShowQuery;
use Project\Domains\Admin\University\Application\Application\Queries\StatusList\Query as StatusListQuery;
use Project\Infrastructure\Generators\Contracts\UuidGeneratorInterface;
use Project\Shared\Domain\Bus\Command\CommandBusInterface;
use Project\Shared\Domain\Bus\Query\QueryBusInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

readonly class ApplicationController
{
    public function __construct(
        private ResponseFactory $response,
        private UuidGeneratorInterface $uuidGenerator,
        private CommandBusInterface $commandBus,
        private QueryBusInterface $queryBus
    )
    {

    }

    public function index(Request $request): JsonResponse
    {
        return $this->response->json(
            $this->queryBus->ask(
                IndexQuery::makeFromRequest($request)
            )
        );
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
                $request->boolean('is_agreed_to_share_data', true),
                'admin',
                $request->get('company_uuid'),
                $request->get('father_name'),
                $request->get('mother_name'),
                $request->get('friend_phone'),
                $request->get('home_address'),
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

    public function update(ApplicationUpdateRequest $request, string $uuid): Response
    {
        [
            'value' => $statusValue,
            'translations' => $statusTranslations,
        ] = $request->get('status');

        $this->commandBus->dispatch(
            new UpdateCommand(
                $uuid,
                $request->get('full_name'),
                $request->get('birthday'),
                $request->get('passport_number'),
                $request->get('email'),
                $request->get('phone'),
                $request->get('university_uuid'),
                $request->get('department_uuids'),
                $request->get('country_uuid'),
                $statusValue,
                $statusTranslations ?? [],

                $request->get('father_name'),
                $request->get('mother_name'),
                $request->get('friend_phone'),
                $request->get('home_address')
            )
        );

        return $this->response->noContent(Response::HTTP_ACCEPTED);
    }

    public function delete(string $uuid): Response
    {
        $this->commandBus->dispatch(
            new DeleteCommand($uuid)
        );

        return $this->response->noContent();
    }

    public function statusList(): JsonResponse
    {
        return $this->response->json(
            $this->queryBus->ask(
                new StatusListQuery()
            )
        );
    }
}
