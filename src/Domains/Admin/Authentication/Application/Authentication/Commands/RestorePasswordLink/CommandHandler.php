<?php

declare(strict_types=1);

namespace Project\Domains\Admin\Authentication\Application\Authentication\Commands\RestorePasswordLink;

use Illuminate\Database\Eloquent\ModelNotFoundException;
use Project\Domains\Admin\Authentication\Domain\Code\Code;
use Project\Domains\Admin\Manager\Domain\Manager\ManagerRepositoryInterface;
use Project\Domains\Admin\Manager\Domain\Manager\ValueObjects\Email;
use Project\Infrastructure\Generators\Contracts\TokenGeneratorInterface;
use Project\Shared\Domain\Bus\Command\CommandHandlerInterface;
use Project\Shared\Domain\Bus\Event\EventBusInterface;

readonly class CommandHandler implements CommandHandlerInterface
{
    function __construct(
        private ManagerRepositoryInterface $repository,
        private TokenGeneratorInterface    $tokenGenerator,
        private EventBusInterface          $eventBus
    ) { }

    public function __invoke(Command $command): void
    {
        $member = $this->repository->findByEmail(Email::fromValue($command->email));

        if ($member === null) {
            throw new ModelNotFoundException();
        }

        if ($member->hasCode()) {
            $member->removeCode();
            $this->repository->save($member);
        }

        $code = Code::fromPrimitives(
            $this->tokenGenerator->generate(),
            new \DateTimeImmutable('+ 1 hour')
        );

        $member->addCode($code);
        $this->repository->save($member);
        $this->eventBus->publish(...$member->pullDomainEvents());
    }
}
