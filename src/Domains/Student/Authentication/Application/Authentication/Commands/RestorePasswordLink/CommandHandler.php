<?php

declare(strict_types=1);

namespace Project\Domains\Student\Authentication\Application\Authentication\Commands\RestorePasswordLink;

use DateTimeImmutable;
use Project\Domains\Admin\Student\Domain\Student\StudentRepositoryInterface;
use Project\Domains\Admin\Student\Domain\Student\Exceptions\StudentNotFountExceptionDomainException;
use Project\Domains\Admin\Student\Domain\Student\ValueObjects\Email;
use Project\Domains\Student\Authentication\Domain\Code\Code;
use Project\Infrastructure\Generators\Contracts\TokenGeneratorInterface;
use Project\Shared\Domain\Bus\Command\CommandHandlerInterface;
use Project\Shared\Domain\Bus\Event\EventBusInterface;

readonly class CommandHandler implements CommandHandlerInterface
{
    function __construct(
        private StudentRepositoryInterface $repository,
        private TokenGeneratorInterface $tokenGenerator,
        private EventBusInterface $eventBus
    ) { }

    public function __invoke(Command $command): void
    {
        $employee = $this->repository->findByEmail(Email::fromValue($command->email));

        if ($employee === null) {
            throw new StudentNotFountExceptionDomainException();
        }

        if ($employee->hasCode()) {
            $employee->removeCode();
            $this->repository->save($employee);
        }

        $code = Code::fromPrimitives(
            $this->tokenGenerator->generate(),
            new DateTimeImmutable('+ 1 hour')
        );

        $employee->addCode($code);
        $this->repository->save($employee);
        $this->eventBus->publish(...$employee->pullDomainEvents());
    }
}
