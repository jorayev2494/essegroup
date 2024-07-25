<?php

declare(strict_types=1);

namespace Project\Domains\Admin\Manager\Application\Role\Commands\Update;

use Project\Domains\Admin\Manager\Domain\Role\Exceptions\RoleNotFoundDomainException;
use Project\Domains\Admin\Manager\Domain\Role\RoleRepositoryInterface;
use Project\Domains\Admin\Manager\Domain\Role\ValueObjects\Uuid;
use Project\Shared\Domain\Bus\Command\CommandHandlerInterface;
use Project\Shared\Domain\Translation\TranslationColumnServiceInterface;

readonly class CommandHandler implements CommandHandlerInterface
{
    public function __construct(
        private RoleRepositoryInterface $repository,
        private TranslationColumnServiceInterface $translationColumnService
    ) { }

    public function __invoke(Command $command): void
    {
        $role = $this->repository->findByUuid(Uuid::fromValue($command->uuid));

        $role ?? throw new RoleNotFoundDomainException();

        $role->setIsActive($command->isActive);
        $this->translationColumnService->addTranslations($role, $command->translations);

        $this->repository->save($role);
    }
}