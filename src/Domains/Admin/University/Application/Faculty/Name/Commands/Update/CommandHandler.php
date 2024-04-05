<?php

declare(strict_types=1);

namespace Project\Domains\Admin\University\Application\Faculty\Name\Commands\Update;

use Project\Domains\Admin\University\Domain\Faculty\Name\Exception\FacultyNameNotFoundDomainException;
use Project\Domains\Admin\University\Domain\Faculty\Name\FacultyNameRepositoryInterface;
use Project\Domains\Admin\University\Domain\Faculty\Name\ValueObjects\Uuid;
use Project\Shared\Domain\Bus\Command\CommandHandlerInterface;
use Project\Shared\Domain\Translation\TranslationColumnServiceInterface;

readonly class CommandHandler implements CommandHandlerInterface
{
    public function __construct(
        private FacultyNameRepositoryInterface    $nameRepository,
        private TranslationColumnServiceInterface $translationColumnService
    ) {

    }

    public function __invoke(Command $command): void
    {
        $name = $this->nameRepository->findByUuid(Uuid::fromValue($command->uuid));

        $name ?? throw new FacultyNameNotFoundDomainException();

        $this->translationColumnService->addTranslations($name, $command->translations);

        $this->nameRepository->save($name);
    }
}
