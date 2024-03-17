<?php

declare(strict_types=1);

namespace App\Http\Middleware;

use Closure;
use Doctrine\ORM\EntityManagerInterface;
use Illuminate\Http\Request;
use Project\Shared\Infrastructure\Repository\Contracts\BoundedContexts\AdminEntityManagerInterface;
use Project\Shared\Infrastructure\Repository\Contracts\BoundedContexts\ClientEntityManagerInterface;
use Project\Shared\Infrastructure\Repository\Contracts\BoundedContexts\CompanyEntityManagerInterface;
use Symfony\Component\HttpFoundation\Response;

readonly class DoctrineFlusherMiddleware
{
    public function __construct(
        private AdminEntityManagerInterface $adminEntityManager,
        private CompanyEntityManagerInterface $companyEntityManager,
        private ClientEntityManagerInterface $clientEntityManager,
    ) {

    }

    public function handle(Request $request, Closure $next): Response
    {
        return $next($request);
    }

    public function terminate(Request $request, Response $response): void
    {
        $entityManagers = [
            $this->adminEntityManager,
            $this->companyEntityManager,
            $this->clientEntityManager,
        ];

        /** @var EntityManagerInterface $entityManager */
        foreach ($entityManagers as $entityManager)
        {
            $entityManager->flush();
        }
    }
}
