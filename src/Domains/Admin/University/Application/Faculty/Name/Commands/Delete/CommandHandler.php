<?php

declare(strict_types=1);

namespace Project\Domains\Admin\University\Application\Faculty\Name\Commands\Delete;

use Project\Domains\Admin\University\Domain\Faculty\Name\Exception\FacultyNameNotFoundDomainException;
use Project\Domains\Admin\University\Domain\Faculty\Name\FacultyNameRepositoryInterface;
use Project\Domains\Admin\University\Domain\Faculty\Name\ValueObjects\Uuid;
use Project\Shared\Domain\Bus\Command\CommandHandlerInterface;

readonly class CommandHandler implements CommandHandlerInterface
{
    public function __construct(
        private FacultyNameRepositoryInterface    $nameRepository
    ) {

    }

    public function __invoke(Command $command): void
    {
        $name = $this->nameRepository->findByUuid(Uuid::fromValue($command->uuid));

        $name ?? throw new FacultyNameNotFoundDomainException();

        $this->nameRepository->delete($name);
    }
}
