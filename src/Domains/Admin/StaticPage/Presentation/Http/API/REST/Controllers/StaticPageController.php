<?php

declare(strict_types=1);

namespace Project\Domains\Admin\StaticPage\Presentation\Http\API\REST\Controllers;

use App\Http\Requests\Api\Admin\StaticPage\UpdateRequest;
use Illuminate\Contracts\Routing\ResponseFactory;
use Project\Domains\Admin\StaticPage\Applicaiton\StaticPage\Commands\Update\Command as UpdateCommand;
use Project\Domains\Admin\StaticPage\Applicaiton\StaticPage\Queries\Show\Query as ShowQuery;
use Project\Shared\Domain\Bus\Command\CommandBusInterface;
use Project\Shared\Domain\Bus\Query\QueryBusInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

readonly class StaticPageController
{
    public function __construct(
        private ResponseFactory $response,
        private CommandBusInterface $commandBus,
        private QueryBusInterface $queryBus
    ) { }

    public function show(string $slug): JsonResponse
    {
        return $this->response->json(
            $this->queryBus->ask(
                new ShowQuery(
                    $slug
                )
            )
        );
    }

    public function update(UpdateRequest $request, string $slug): Response
    {
        $this->commandBus->dispatch(
            new UpdateCommand(
                $slug,
                $request->get('translations'),
                $request->file('cover')
            )
        );

        return $this->response->noContent(Response::HTTP_ACCEPTED);
    }
}
