<?php

declare(strict_types=1);

namespace Project\Domains\Company\University\Application\Application\Commands\Update;

use Project\Domains\Company\University\Domain\Aplication\Services\Contracts\ApplicationServiceInterface;
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
