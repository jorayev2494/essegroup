<?php

declare(strict_types=1);

namespace Project\Domains\Admin\Token\Presentation\Http\API\REST\Controllers;

use Illuminate\Contracts\Routing\ResponseFactory;
use Project\Domains\Admin\Token\Application\Queries\Centrifugo\GenerateConnectionToken\Query as GenerateConnectionTokenQuery;
use Project\Shared\Domain\Bus\Query\QueryBusInterface;
use Symfony\Component\HttpFoundation\JsonResponse;

readonly class TokenController
{
    public function __construct(
        private ResponseFactory $response,
        private QueryBusInterface $queryBus
    ) { }

    public function centrifugeGenerateConnectionToken(): JsonResponse
    {
        return $this->response->json(
            $this->queryBus->ask(
                new GenerateConnectionTokenQuery()
            )
        );
    }
}