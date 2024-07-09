<?php

declare(strict_types=1);

namespace Project\Domains\Admin\University\Application\University\Queries\Show;

use Illuminate\Database\Eloquent\ModelNotFoundException;
use Project\Domains\Admin\University\Domain\University\UniversityRepositoryInterface;
use Project\Domains\Admin\University\Domain\University\ValueObjects\Uuid;
use Project\Shared\Domain\Bus\Query\QueryHandlerInterface;

readonly class QueryHandler implements QueryHandlerInterface
{
    public function __construct(
        private UniversityRepositoryInterface $repository,
    )
    {

    }

    public function __invoke(Query $query): array
    {
        $university = $this->repository->findByUuid(Uuid::fromValue($query->uuid));

        $university ?? throw new ModelNotFoundException();

        return $university->toArrayWithTranslations();
    }
}
