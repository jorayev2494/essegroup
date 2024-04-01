<?php

declare(strict_types=1);

namespace Project\Domains\Admin\University\Application\Alias\Commands\Delete;

use Project\Domains\Admin\University\Domain\Alias\AliasRepositoryInterface;
use Project\Domains\Admin\University\Domain\Alias\Exceptions\AliasNotFoundExceptionDomainException;
use Project\Domains\Admin\University\Domain\Alias\ValueObjects\Uuid;
use Project\Shared\Domain\Bus\Command\CommandHandlerInterface;

readonly class CommandHandler implements CommandHandlerInterface
{
    public function __construct(
        private AliasRepositoryInterface $repository
    )
    {

    }

    public function __invoke(Command $command): void
    {
        $alias = $this->repository->findByUuid(Uuid::fromValue($command->uuid));

        $alias ?? throw new AliasNotFoundExceptionDomainException();

        $this->repository->delete($alias);
    }
}
