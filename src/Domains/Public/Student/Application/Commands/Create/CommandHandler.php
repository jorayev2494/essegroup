<?php

declare(strict_types=1);

namespace Project\Domains\Public\Student\Application\Commands\Create;

use Project\Domains\Public\Student\Domian\Student\Services\Contracts\StudentServiceInterface;
use Project\Shared\Domain\Bus\Command\CommandHandlerInterface;

readonly class CommandHandler implements CommandHandlerInterface
{
    public function __construct(
        private StudentServiceInterface $service
    ) { }

    public function __invoke(Command $command): void
    {
        $this->service->create($command);
    }
}
