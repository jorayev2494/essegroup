<?php

declare(strict_types=1);

namespace Project\Domains\Student\University\Application\Application\Commands\Update;

use Project\Domains\Student\University\Domain\Aplication\Services\Contracts\ApplicationServiceInterface;
use Project\Shared\Domain\Bus\Command\CommandHandlerInterface;

readonly class CommandHandler implements CommandHandlerInterface
{
    public function __construct(
        private ApplicationServiceInterface $service
    ) { }

    public function __invoke(Command $command): void
    {
        $this->service->update($command);
    }
}
