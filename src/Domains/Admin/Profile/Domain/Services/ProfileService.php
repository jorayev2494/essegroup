<?php

declare(strict_types=1);

namespace Project\Domains\Admin\Profile\Domain\Services;

use Project\Domains\Admin\Manager\Application\Manager\Commands\Update\Command;
use Project\Domains\Admin\Manager\Application\Manager\Queries\Show\Query;
use Project\Domains\Admin\Profile\Domain\Services\Contracts\ProfileServiceInterface;
use Project\Infrastructure\Services\Auth\AuthManager;
use Project\Infrastructure\Services\Authentication\Enums\GuardType;
use Project\Shared\Domain\Bus\Command\CommandBusInterface;
use Project\Shared\Domain\Bus\Query\QueryBusInterface;
use Symfony\Component\HttpFoundation\File\UploadedFile;

readonly class ProfileService implements ProfileServiceInterface
{
    public function show(): array
    {
        /** @var QueryBusInterface $queryBus */
        $queryBus = resolve(QueryBusInterface::class);

        return $queryBus->ask(new Query(AuthManager::uuid(GuardType::MANAGER)->value));
    }

    public function update(string $firstName, string $lastName, string $email, ?UploadedFile $avatar): void
    {
        /** @var CommandBusInterface $commandBus */
        $commandBus = resolve(CommandBusInterface::class);

        $commandBus->dispatch(
            new Command(
                AuthManager::uuid(GuardType::MANAGER)->value,
                $firstName,
                $lastName,
                $avatar,
                $email
            )
        );
    }
}
