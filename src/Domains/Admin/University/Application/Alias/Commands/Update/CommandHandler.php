<?php

declare(strict_types=1);

namespace Project\Domains\Admin\University\Application\Alias\Commands\Update;

use Project\Domains\Admin\University\Domain\Alias\Alias;
use Project\Domains\Admin\University\Domain\Alias\AliasRepositoryInterface;
use Project\Domains\Admin\University\Domain\Alias\Exceptions\AliasNotFoundExceptionDomainException;
use Project\Domains\Admin\University\Domain\Alias\ValueObjects\Uuid;
use Project\Shared\Domain\Bus\Command\CommandHandlerInterface;
use Project\Shared\Domain\Translation\TranslationColumnServiceInterface;

readonly class CommandHandler implements CommandHandlerInterface
{
    public function __construct(
        private AliasRepositoryInterface $repository,
        private TranslationColumnServiceInterface $translationColumnService
    )
    {

    }

    public function __invoke(Command $command): void
    {
        $alias = $this->repository->findByUuid(Uuid::fromValue($command->uuid));

        $alias ?? throw new AliasNotFoundExceptionDomainException();

        $this->translationColumnService->addTranslations($alias, $command->translations);

        $this->repository->save($alias);
    }
}
