<?php

declare(strict_types=1);

namespace Project\Domains\Admin\Token\Application\Queries\Centrifugo\GenerateConnectionToken;

use Project\Infrastructure\Services\Auth\AuthManager;
use Project\Infrastructure\Services\WS\Contracts\WSServiceInterface;
use Project\Shared\Domain\Bus\Query\QueryHandlerInterface;

readonly class QueryHandler implements QueryHandlerInterface
{
    public function __construct(
        private WSServiceInterface $WSService
    ) { }

    public function __invoke(Query $command): array
    {
        $manager = AuthManager::manager();

        $info = [
            'uuid' => $manager->getUuid()->value,
            'first_name' => $manager->getFullName()->getFirstName()->value,
            'last_name' => $manager->getFullName()->getLastName()->value,
        ];

        return [
            'ws_access_token' => $this->WSService->generateConnectionToken($manager, $info),
        ];
    }
}