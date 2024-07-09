<?php

declare(strict_types=1);

namespace Project\Domains\Company\Authentication\Application\Authentication\Commands\RestorePasswordLink;

use Project\Domains\Admin\Company\Domain\Employee\EmployeeRepositoryInterface;
use Project\Domains\Admin\Company\Domain\Employee\Exceptions\EmployeeNotFoundDomainException;
use Project\Domains\Admin\Company\Domain\Employee\ValueObjects\Email;
use Project\Domains\Company\Authentication\Domain\Code\Code;
use Project\Infrastructure\Generators\Contracts\TokenGeneratorInterface;
use Project\Shared\Domain\Bus\Command\CommandHandlerInterface;
use Project\Shared\Domain\Bus\Event\EventBusInterface;

readonly class CommandHandler implements CommandHandlerInterface
{
    function __construct(
        private EmployeeRepositoryInterface $repository,
        private TokenGeneratorInterface $tokenGenerator,
        private EventBusInterface $eventBus
    ) { }

    public function __invoke(Command $command): void
    {
        $employee = $this->repository->findByEmail(Email::fromValue($command->email));

        if ($employee === null) {
            throw new EmployeeNotFoundDomainException();
        }

        if ($employee->hasCode()) {
            $employee->removeCode();
            $this->repository->save($employee);
        }

        $code = Code::fromPrimitives(
            $this->tokenGenerator->generate(),
            new \DateTimeImmutable('+ 1 hour')
        );

        $employee->addCode($code);
        $this->repository->save($employee);
        $this->eventBus->publish(...$employee->pullDomainEvents());
    }
}
