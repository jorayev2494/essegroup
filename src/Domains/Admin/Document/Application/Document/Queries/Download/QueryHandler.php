<?php

declare(strict_types=1);

namespace Project\Domains\Admin\Document\Application\Document\Queries\Download;

use Project\Domains\Admin\Document\Domain\Document\DocumentRepositoryInterface;
use Project\Domains\Admin\Document\Domain\Document\DocumentTranslate;
use Project\Domains\Admin\Document\Domain\Document\Exceptions\DocumentNotFoundDomainException;
use Project\Domains\Admin\Document\Domain\Document\Services\File\Contracts\FileServiceInterface;
use Project\Domains\Admin\Document\Domain\Document\ValueObjects\Uuid;
use Project\Shared\Domain\Bus\Query\QueryHandlerInterface;
use Symfony\Component\HttpFoundation\StreamedResponse;

readonly class QueryHandler implements QueryHandlerInterface
{
    public function __construct(
        private DocumentRepositoryInterface $repository,
        private FileServiceInterface $fileService
    ) { }

    public function __invoke(Query $query): StreamedResponse
    {
        $document = $this->repository->findByUuid(Uuid::fromValue($query->uuid));

        $document ?? throw new DocumentNotFoundDomainException();

        $document->getFile()->incrementDownloadedCount();

        $this->repository->save($document);

        return $this->fileService->download($document->getFile(), 'document');
    }
}
