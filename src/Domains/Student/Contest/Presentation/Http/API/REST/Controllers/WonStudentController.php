<?php

declare(strict_types=1);

namespace Project\Domains\Student\Contest\Presentation\Http\API\REST\Controllers;

use Illuminate\Contracts\Routing\ResponseFactory;
use Project\Domains\Student\Contest\Application\WonStudent\Queries\GetByContestAndStudent\Query as GetByContestAndStudentQuery;
use Project\Shared\Domain\Bus\Query\QueryBusInterface;
use Symfony\Component\HttpFoundation\JsonResponse;

readonly class WonStudentController
{
    public function __construct(
        private ResponseFactory $response,
        private QueryBusInterface $queryBus
    ) { }

    public function showContestStudent(string $contestUuid): JsonResponse
    {
        return $this->response->json(
            $this->queryBus->ask(
                new GetByContestAndStudentQuery(
                    $contestUuid
                )
            )
        );
    }
}
