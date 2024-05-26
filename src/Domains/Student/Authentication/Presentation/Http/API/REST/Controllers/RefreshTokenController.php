<?php

declare(strict_types=1);

namespace Project\Domains\Student\Authentication\Presentation\Http\API\REST\Controllers;

use App\Http\Requests\Api\Student\Authentication\RefreshTokenRequest;
use Illuminate\Contracts\Routing\ResponseFactory;
use Project\Domains\Student\Authentication\Application\Authentication\Commands\RefreshToken\CommandHandler;
use Project\Domains\Student\Authentication\Application\Authentication\Commands\RefreshToken\Command;
use Symfony\Component\HttpFoundation\JsonResponse;

readonly class RefreshTokenController
{
    public function __construct(
        private ResponseFactory $response,
    )
    {

    }

    public function __invoke(RefreshTokenRequest $request, CommandHandler $handler): JsonResponse
    {
        return $this->response->json(
            $handler(
                new Command(
                    $request->headers->get('x-device-id'),
                    $request->post('refresh_token'),
                )
            )
        );
    }
}
