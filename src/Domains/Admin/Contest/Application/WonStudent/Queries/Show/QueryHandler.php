<?php

declare(strict_types=1);

namespace Project\Domains\Admin\Contest\Application\WonStudent\Queries\Show;

use Project\Domains\Admin\Contest\Domain\WonStudent\Exceptions\WonStudentNotFoundDomainException;
use Project\Domains\Admin\Contest\Domain\WonStudent\ValueObjects\Code;
use Project\Domains\Admin\Contest\Domain\WonStudent\WonStudentRepositoryInterface;
use Project\Shared\Domain\Bus\Query\QueryHandlerInterface;

readonly class QueryHandler implements QueryHandlerInterface
{
    public function __construct(
        private WonStudentRepositoryInterface $repository
    ) { }

    public function __invoke(Query $query): array
    {
        $wonStudent = $this->repository->findByCode(Code::fromValue($query->code));

        $wonStudent ?? throw new WonStudentNotFoundDomainException();

        return $wonStudent->toArray();
    }
}
