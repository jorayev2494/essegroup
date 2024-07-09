<?php

declare(strict_types=1);

namespace Project\Domains\Student\Authentication\Presentation\Http\API\REST\Controllers;

use Illuminate\Contracts\Routing\ResponseFactory;
use Symfony\Component\HttpFoundation\Response;

readonly class LogoutController
{
    public function __construct(
        private ResponseFactory $response,
    )
    {

    }

    public function __invoke(): Response
    {
        return $this->response->noContent();
    }
}
