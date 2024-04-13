<?php

declare(strict_types=1);

namespace Project\Domains\Admin\Student\Application\Queries\Show;

use Project\Domains\Admin\Student\Domain\Student\Exceptions\StudentNotFountExceptionDomainException;
use Project\Domains\Admin\Student\Domain\Student\StudentRepositoryInterface;
use Project\Domains\Admin\Student\Domain\Student\ValueObjects\Uuid;
use Project\Shared\Domain\Bus\Query\QueryHandlerInterface;

readonly class QueryHandler implements QueryHandlerInterface
{
    public function __construct(
        private StudentRepositoryInterface $repository
    ) { }

    public function __invoke(Query $query): array
    {
        $student = $this->repository->findByUuid(Uuid::fromValue($query->uuid));

        $student ?? throw new StudentNotFountExceptionDomainException();

        return $student->toArray();
    }
}
