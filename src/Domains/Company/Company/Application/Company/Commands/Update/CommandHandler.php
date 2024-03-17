<?php

declare(strict_types=1);

namespace Project\Domains\Company\Company\Application\Company\Commands\Update;

use Project\Domains\Company\Company\Domain\Company\Services\Contracts\CompanyServiceInterface;
use Project\Shared\Domain\Bus\Command\CommandHandlerInterface;

readonly class CommandHandler implements CommandHandlerInterface
{
    public function __construct(
        private CompanyServiceInterface $service,
    )
    {

    }

    public function __invoke(Command $command): void
    {
        $this->service->update($command);
    }
}
