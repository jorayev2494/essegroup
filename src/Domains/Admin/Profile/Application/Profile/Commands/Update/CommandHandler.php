<?php

declare(strict_types=1);

namespace Project\Domains\Admin\Profile\Application\Profile\Commands\Update;

use Project\Domains\Admin\Profile\Domain\Services\Contracts\ProfileServiceInterface;
use Project\Shared\Domain\Bus\Command\CommandHandlerInterface;

readonly class CommandHandler implements CommandHandlerInterface
{
    public function __construct(
        public ProfileServiceInterface $service
    ) { }

    public function __invoke(Command $command): void
    {
        $this->service->update(
            $command->firstName,
            $command->lastName,
            $command->email,
            $command->avatar
        );
    }
}
