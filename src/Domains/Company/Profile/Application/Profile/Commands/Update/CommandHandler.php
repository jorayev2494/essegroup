<?php

declare(strict_types=1);

namespace Project\Domains\Company\Profile\Application\Profile\Commands\Update;

use Project\Domains\Company\Profile\Domain\Profile\Services\Contracts\ProfileServiceInterface;
use Project\Infrastructure\Services\Auth\AuthManager;
use Project\Infrastructure\Services\Authentication\Enums\GuardType;
use Project\Shared\Domain\Bus\Command\CommandHandlerInterface;

readonly class CommandHandler implements CommandHandlerInterface
{
    public function __construct(
        private ProfileServiceInterface $service
    ) { }

    public function __invoke(Command $command): void
    {
        $this->service->update(AuthManager::uuid(GuardType::COMPANY), $command);
    }
}
