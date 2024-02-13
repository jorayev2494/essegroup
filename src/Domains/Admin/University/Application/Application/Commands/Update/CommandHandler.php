<?php

declare(strict_types=1);

namespace Project\Domains\Admin\University\Application\Application\Commands\Update;

use Project\Domains\Admin\University\Domain\Application\ApplicationRepositoryInterface;
use Project\Domains\Admin\University\Domain\Application\Exceptions\ApplicationNotFoundDomainException;
use Project\Domains\Admin\University\Domain\Application\Services\Contracts\StatusServiceInterface;
use Project\Domains\Admin\University\Domain\Application\ValueObjects\Email;
use Project\Domains\Admin\University\Domain\Application\ValueObjects\Phone;
use Project\Domains\Admin\University\Domain\Application\ValueObjects\Status;
use Project\Domains\Admin\University\Domain\Application\ValueObjects\Uuid;
use Project\Shared\Domain\Bus\Command\CommandHandlerInterface;

readonly class CommandHandler implements CommandHandlerInterface
{
    public function __construct(
        private ApplicationRepositoryInterface $applicationRepository,
        private StatusServiceInterface $statusService
    )
    {

    }

    public function __invoke(Command $command): void
    {
        $application = $this->applicationRepository->findByUuid(Uuid::fromValue($command->uuid));

        $application ?? throw new ApplicationNotFoundDomainException();

        $application->changeEmail(Email::fromValue($command->email));
        $application->changePhone(Phone::fromValue($command->phone));
        $this->statusService->changeStatus($application, Status::fromPrimitives($command->status, $command->note));

        $this->applicationRepository->save($application);
    }
}
