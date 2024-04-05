<?php

declare(strict_types=1);

namespace Project\Domains\Admin\University\Application\DepartmentName\Queries\Show;

use Project\Domains\Admin\University\Domain\Department\Name\DepartmentNameRepositoryInterface;
use Project\Domains\Admin\University\Domain\Department\Name\DepartmentNameTranslate;
use Project\Domains\Admin\University\Domain\Department\Name\Exceptions\DepartmentNameNotFoundDomainException;
use Project\Domains\Admin\University\Domain\Department\Name\ValueObjects\Uuid;
use Project\Shared\Domain\Bus\Query\QueryHandlerInterface;

readonly class QueryHandler implements QueryHandlerInterface
{
    public function __construct(
        private DepartmentNameRepositoryInterface $nameRepository
    ) {

    }

    public function __invoke(Query $query): array
    {
        $departmentName = $this->nameRepository->findByUuid(Uuid::fromValue($query->uuid));

        $departmentName ?? throw new DepartmentNameNotFoundDomainException();

        return DepartmentNameTranslate::execute($departmentName)->toArrayWithTranslations();
    }
}
