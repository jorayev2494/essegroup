<?php

declare(strict_types=1);

namespace Project\Domains\Admin\Contest\Application\Contest\Commands\Delete;

use Project\Domains\Admin\Contest\Domain\Contest\ContestRepositoryInterface;
use Project\Domains\Admin\Contest\Domain\Contest\Exceptions\ContestNotFoundDomainException;
use Project\Domains\Admin\Contest\Domain\Contest\ValueObjects\Uuid;
use Project\Shared\Domain\Bus\Command\CommandHandlerInterface;

readonly class CommandHandler implements CommandHandlerInterface
{
    public function __construct(
        private ContestRepositoryInterface $repository
    ) { }

    public function __invoke(Command $command): void
    {
        $contest = $this->repository->findByUuid(Uuid::fromValue($command->uuid));

        $contest ?? throw new ContestNotFoundDomainException();

        $this->repository->delete($contest);
    }
}
