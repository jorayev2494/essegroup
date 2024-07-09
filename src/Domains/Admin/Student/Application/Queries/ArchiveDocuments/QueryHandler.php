<?php

declare(strict_types=1);

namespace Project\Domains\Admin\Student\Application\Queries\ArchiveDocuments;

use Project\Domains\Admin\Student\Domain\Student\Exceptions\StudentNotFountExceptionDomainException;
use Project\Domains\Admin\Student\Domain\Student\Services\Archive\Contracts\ArchiveServiceInterface;
use Project\Domains\Admin\Student\Domain\Student\StudentRepositoryInterface;
use Project\Domains\Admin\Student\Domain\Student\ValueObjects\Uuid;
use Project\Shared\Domain\Bus\Query\QueryHandlerInterface;
use Symfony\Component\HttpFoundation\StreamedResponse;

readonly class QueryHandler implements QueryHandlerInterface
{
    public function __construct(
        private StudentRepositoryInterface $repository,
        private ArchiveServiceInterface $archiveService
    ) { }

    public function __invoke(Query $query): StreamedResponse
    {
        $foundStudent = $this->repository->findByUuid(Uuid::fromValue($query->uuid));

        $foundStudent ?? throw new StudentNotFountExceptionDomainException();

        return $this->archiveService->archiveDocuments(
            $foundStudent,
            $foundStudent->getFullName()->getFullName()
        )->response();
    }
}
