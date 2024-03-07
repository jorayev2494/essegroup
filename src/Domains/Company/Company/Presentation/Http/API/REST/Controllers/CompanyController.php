<?php

declare(strict_types=1);

namespace Project\Domains\Company\Company\Presentation\Http\API\REST\Controllers;

use App\Http\Requests\Api\Admin\Company\Company\CompanyUpdateRequest;
use Illuminate\Contracts\Routing\ResponseFactory;
use Project\Shared\Domain\Bus\Command\CommandBusInterface;
use Project\Shared\Domain\Bus\Query\QueryBusInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Project\Domains\Company\Company\Application\Company\Queries\Show\Query as ShowQuery;
use Project\Domains\Company\Company\Application\Company\Commands\Update\Command as UpdateCommand;

readonly class CompanyController
{
    public function __construct(
        private ResponseFactory $response,
        private CommandBusInterface $commandBus,
        private QueryBusInterface $queryBus
    )
    {

    }

    public function show(): JsonResponse
    {
        return $this->response->json(
            $this->queryBus->ask(
                new ShowQuery()
            )
        );
    }

    public function update(CompanyUpdateRequest $request, string $uuid): Response
    {
        $this->commandBus->dispatch(
            new UpdateCommand(
                $uuid,
                $request->file('logo'),
                $request->get('name'),
                $request->get('domain'),
            )
        );
        return $this->response->noContent(Response::HTTP_ACCEPTED);
    }
}
