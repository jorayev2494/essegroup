<?php

declare(strict_types=1);

namespace Project\Domains\Admin\University\Application\Department\Queries\Show;

use Illuminate\Database\Eloquent\ModelNotFoundException;
use Project\Domains\Admin\University\Domain\Department\DepartmentRepositoryInterface;
use Project\Domains\Admin\University\Domain\Department\DepartmentTranslate;
use Project\Domains\Admin\University\Domain\Department\ValueObjects\Uuid;
use Project\Shared\Domain\Bus\Query\QueryHandlerInterface;

readonly class QueryHandler implements QueryHandlerInterface
{
    public function __construct(
        private DepartmentRepositoryInterface $departmentRepository
    )
    {

    }

    public function __invoke(Query $query): array
    {
        $department = $this->departmentRepository->findByUuid(Uuid::fromValue($query->uuid));

        $department ?? throw new ModelNotFoundException();

        return DepartmentTranslate::execute($department)->toArrayWithTranslations();
    }
}
