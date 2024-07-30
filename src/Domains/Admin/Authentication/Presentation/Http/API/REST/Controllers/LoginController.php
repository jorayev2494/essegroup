<?php

declare(strict_types=1);

namespace Project\Domains\Admin\Authentication\Presentation\Http\API\REST\Controllers;

use App\Http\Requests\Api\Admin\Authentication\LoginRequest;
use App\Http\Requests\Api\Admin\Authentication\RefreshTokenRequest;
use Illuminate\Contracts\Routing\ResponseFactory;
use Project\Domains\Admin\Authentication\Application\Authentication\Commands\Login\Command;
use Project\Domains\Admin\Authentication\Application\Authentication\Commands\Login\CommandHandler;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

readonly class LoginController
{
    public function __construct(
        private ResponseFactory $response,
    ) { }

    public function __invoke(LoginRequest $request, CommandHandler $handler): Response
    {
        return $this->response->json(
            $handler(
                new Command(
                    $request->get('email'),
                    $request->get('password'),
                    $request->headers->get('x-device-id'),
                )
            )
        );
    }
}
