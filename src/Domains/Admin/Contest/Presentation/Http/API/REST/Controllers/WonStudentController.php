<?php

declare(strict_types=1);

namespace Project\Domains\Admin\Contest\Presentation\Http\API\REST\Controllers;

use App\Http\Requests\Api\Admin\Contest\WonStudent\UpdateRequest;
use Illuminate\Contracts\Routing\ResponseFactory;
use Project\Domains\Admin\Contest\Application\WonStudent\Commands\Create\Command as SelectWinnerStudentCommand;
use Project\Domains\Admin\Contest\Application\WonStudent\Commands\Create\CommandHandler as SelectWinnerStudentCommandHandler;
use Project\Domains\Admin\Contest\Application\WonStudent\Commands\Update\Command as UpdateCommand;
use Project\Domains\Admin\Contest\Application\WonStudent\Queries\Index\Query as WonStudentsQuery;
use Project\Domains\Admin\Contest\Application\WonStudent\Queries\GetByContestAndStudent\Query as GetByContestAndStudentQuery;
use Project\Domains\Admin\Contest\Application\WonStudent\Queries\Show\Query as ShowQuery;
use Project\Shared\Domain\Bus\Command\CommandBusInterface;
use Project\Shared\Domain\Bus\Query\QueryBusInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

readonly class WonStudentController
{
    public function __construct(
        private ResponseFactory $response,
        private CommandBusInterface $commandBus,
        private QueryBusInterface $queryBus
    ) { }

    public function index(Request $request, string $contestUuid): JsonResponse
    {
        return $this->response->json(
            $this->queryBus->ask(
                WonStudentsQuery::makeFromRequest($request)
                    ->setContestUuid($contestUuid)
            )
        );
    }

    public function store(SelectWinnerStudentCommandHandler $handler, string $uuid): JsonResponse
    {
        return $this->response->json(
            $handler(
                new SelectWinnerStudentCommand($uuid)
            )
        );
    }

    public function showContestStudent(string $contestUuid, string $studentUuid): JsonResponse
    {
        return $this->response->json(
            $this->queryBus->ask(
                new GetByContestAndStudentQuery(
                    $contestUuid,
                    $studentUuid
                )
            )
        );
    }

    public function show(string $contestUuid, int $code): JsonResponse
    {
        return $this->response->json(
            $this->queryBus->ask(
                new ShowQuery($code)
            )
        );
    }

    public function update(UpdateRequest $request, string $contestUuid, int $code): Response
    {
        $this->commandBus->dispatch(
            new UpdateCommand(
                $code,
                $request->get('gift_given_at'),
                $request->get('note')
            )
        );

        return $this->response->noContent(Response::HTTP_ACCEPTED);
    }
}
