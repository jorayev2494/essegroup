<?php

declare(strict_types=1);

namespace Project\Domains\Admin\University\Application\ApplicationStatusValue\Commands\Delete;

use Project\Domains\Admin\University\Domain\Application\Exceptions\StatusValueNotFoundDomainException;
use Project\Domains\Admin\University\Domain\Application\StatusValueRepositoryInterface;
use Project\Domains\Admin\University\Domain\Application\ValueObjects\StatusValueUuid;
use Project\Shared\Domain\Bus\Command\CommandHandlerInterface;

readonly class CommandHandler implements CommandHandlerInterface
{
    public function __construct(
        private StatusValueRepositoryInterface $statusValueRepository
    ) { }

    public function __invoke(Command $command): void
    {
        $statusValue = $this->statusValueRepository->findByUuid(StatusValueUuid::fromValue($command->uuid));

        $statusValue ?? throw new StatusValueNotFoundDomainException();

        $this->statusValueRepository->delete($statusValue);
    }
}
