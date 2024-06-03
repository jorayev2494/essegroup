<?php

declare(strict_types=1);

namespace Project\Domains\Admin\Student\Application\Queries\PDFPreview;

use Project\Domains\Admin\Student\Domain\Student\Exceptions\StudentNotFountExceptionDomainException;
use Project\Domains\Admin\Student\Domain\Student\Services\Contracts\PDFServiceInterface;
use Project\Domains\Admin\Student\Domain\Student\StudentRepositoryInterface;
use Project\Domains\Admin\Student\Domain\Student\ValueObjects\Uuid;
use Project\Shared\Domain\Bus\Query\QueryHandlerInterface;

readonly class QueryHandler implements QueryHandlerInterface
{
    public function __construct(
        private StudentRepositoryInterface $repository,
        private PDFServiceInterface $PDFService
    ) { }

    public function __invoke(Query $query): array
    {
        $student = $this->repository->findByUuid(Uuid::fromValue($query->uuid));

        $student ?? throw new StudentNotFountExceptionDomainException();

        return $this->PDFService->preview($student);
    }
}
