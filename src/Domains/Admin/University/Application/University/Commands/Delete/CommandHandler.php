<?php

declare(strict_types=1);

namespace Project\Domains\Admin\University\Application\University\Commands\Delete;

use Illuminate\Database\Eloquent\ModelNotFoundException;
use Project\Domains\Admin\University\Domain\University\UniversityRepositoryInterface;
use Project\Domains\Admin\University\Domain\University\ValueObjects\Uuid;
use Project\Shared\Domain\Bus\Command\CommandHandlerInterface;

readonly class CommandHandler implements CommandHandlerInterface
{
    public function __construct(
        private UniversityRepositoryInterface $repository,
    )
    {

    }

    public function __invoke(Command $command): void
    {
        $university = $this->repository->findByUuid(Uuid::fromValue($command->uuid));

        $university ?? throw new ModelNotFoundException();

        $this->repository->delete($university);
    }
}
