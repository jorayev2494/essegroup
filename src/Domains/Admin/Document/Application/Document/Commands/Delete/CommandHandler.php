<?php

declare(strict_types=1);

namespace Project\Domains\Admin\Document\Application\Document\Commands\Delete;

use Project\Domains\Admin\Document\Domain\Document\DocumentRepositoryInterface;
use Project\Domains\Admin\Document\Domain\Document\Exceptions\DocumentNotFoundDomainException;
use Project\Domains\Admin\Document\Domain\Document\Services\File\Contracts\FileServiceInterface;
use Project\Domains\Admin\Document\Domain\Document\ValueObjects\Uuid;
use Project\Shared\Domain\Bus\Command\CommandHandlerInterface;

readonly class CommandHandler implements CommandHandlerInterface
{
    public function __construct(
        private DocumentRepositoryInterface $repository,
        private FileServiceInterface $fileService
    ) { }

    public function __invoke(Command $command): void
    {
        $document = $this->repository->findByUuid(Uuid::fromValue($command->uuid));

        $document ?? throw new DocumentNotFoundDomainException();

        $this->fileService->delete($document);

        $this->repository->delete($document);
    }
}
