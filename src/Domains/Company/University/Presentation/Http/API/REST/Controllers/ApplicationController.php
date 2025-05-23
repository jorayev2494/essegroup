<?php

declare(strict_types=1);

namespace Project\Domains\Company\University\Presentation\Http\API\REST\Controllers;

use App\Http\Requests\Api\Company\University\Application\StoreRequest;
use App\Http\Requests\Api\Company\University\Application\UpdateRequest;
use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Http\Request;
use Project\Domains\Company\University\Application\Application\Queries\Index\Query as IndexQuery;
use Project\Domains\Company\University\Application\Application\Queries\ByStudentUuid\Query as ByStudentUuidQuery;
use Project\Domains\Company\University\Application\Application\Commands\Create\Command as CreateCommand;
use Project\Domains\Company\University\Application\Application\Queries\Show\Query as ShowQuery;
use Project\Domains\Company\University\Application\Application\Commands\Update\Command as UpdateCommand;
use Project\Infrastructure\Generators\Contracts\UuidGeneratorInterface;
use Project\Shared\Domain\Bus\Command\CommandBusInterface;
use Project\Shared\Domain\Bus\Query\QueryBusInterface;
use Project\Shared\Infrastructure\Repository\Doctrine\PaginatorHttpQueryParams;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

readonly class ApplicationController
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

    public function studentApplications(Request $request, string $studentUuid): JsonResponse
    {
        return $this->response->json(
            $this->queryBus->ask(
                new ByStudentUuidQuery(
                    $studentUuid,
                    PaginatorHttpQueryParams::makeFromRequest($request)
                )
            )
        );
    }

    public function store(StoreRequest $request): JsonResponse
    {
        $uuid = $this->uuidGenerator->generate();

        $this->commandBus->dispatch(
            new CreateCommand(
                $uuid,
                $request->get('student_uuid'),
                $request->get('alias_uuid'),
                $request->get('language_uuid'),
                $request->get('degree_uuid'),
                $request->get('country_uuid'),
                $request->get('university_uuid'),
                $request->get('department_uuids'),
            )
        );

        return $this->response->json(['uuid' => $uuid], Response::HTTP_CREATED);
    }

    public function update(UpdateRequest $request, string $uuid): Response
    {
        [
            'translations' => $statusTranslations,
        ] = $request->get('status');

        $this->commandBus->dispatch(
            new UpdateCommand(
                $uuid,
                $request->get('alias_uuid'),
                $request->get('language_uuid'),
                $request->get('degree_uuid'),
                $request->get('country_uuid'),
                $request->get('university_uuid'),
                $request->get('department_uuids'),
                $request->get('status_value_uuid'),
                $statusTranslations ?? [],
            )
        );

        return $this->response->noContent(Response::HTTP_ACCEPTED);
    }

    public function show(string $uuid): JsonResponse
    {
        return $this->response->json(
            $this->queryBus->ask(
                new ShowQuery($uuid)
            )
        );
    }
}
