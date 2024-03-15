<?php

declare(strict_types=1);

namespace Project\Domains\Admin\University\Application\University\Commands\Delete;

use Illuminate\Database\Eloquent\ModelNotFoundException;
use Project\Domains\Admin\University\Domain\University\UniversityRepositoryInterface;
use Project\Domains\Admin\University\Domain\University\ValueObjects\Uuid;
use Project\Domains\Admin\University\Infrastructure\Services\Media\Cover\Contracts\CoverServiceInterface;
use Project\Domains\Admin\University\Infrastructure\Services\Media\Logo\Contracts\LogoServiceInterface;
use Project\Shared\Domain\Bus\Command\CommandHandlerInterface;
use Project\Shared\Domain\Bus\Event\EventBusInterface;

readonly class CommandHandler implements CommandHandlerInterface
{
    public function __construct(
        private UniversityRepositoryInterface $repository,
        private LogoServiceInterface $logoService,
        private CoverServiceInterface $coverService,
        private EventBusInterface $eventBus
    )
    {

    }

    public function __invoke(Command $command): void
    {
        $university = $this->repository->findByUuid(Uuid::fromValue($command->uuid));

        $university ?? throw new ModelNotFoundException();

        $this->logoService->delete($university);
        $this->coverService->delete($university);

        $university->delete();
        $this->repository->delete($university);
        $this->eventBus->publish(...$university->pullDomainEvents());
    }
}
