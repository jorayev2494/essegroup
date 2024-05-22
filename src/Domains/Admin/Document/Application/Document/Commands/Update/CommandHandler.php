<?php

declare(strict_types=1);

namespace Project\Domains\Admin\Document\Application\Document\Commands\Update;

use Project\Domains\Admin\Document\Domain\Document\DocumentRepositoryInterface;
use Project\Domains\Admin\Document\Domain\Document\Exceptions\DocumentNotFoundDomainException;
use Project\Domains\Admin\Document\Domain\Document\Services\File\Contracts\FileServiceInterface;
use Project\Domains\Admin\Document\Domain\Document\ValueObjects\TypeEnum;
use Project\Domains\Admin\Document\Domain\Document\ValueObjects\Uuid;
use Project\Shared\Domain\Bus\Command\CommandHandlerInterface;
use Project\Shared\Domain\Translation\TranslationColumnServiceInterface;

readonly class CommandHandler implements CommandHandlerInterface
{
    public function __construct(
        private DocumentRepositoryInterface $repository,
        private TranslationColumnServiceInterface $translationColumnService,
        private FileServiceInterface $fileService
    ) { }

    public function __invoke(Command $command): void
    {
        $document = $this->repository->findByUuid(Uuid::fromValue($command->uuid));

        $document ?? throw new DocumentNotFoundDomainException();

        $document->changeType(TypeEnum::from($command->type));
        $document->changeIsActive($command->isActive);

        $this->translationColumnService->addTranslations($document, $command->translations);
        $this->fileService->update($document, $command->file);

        $this->repository->save($document);
    }
}
