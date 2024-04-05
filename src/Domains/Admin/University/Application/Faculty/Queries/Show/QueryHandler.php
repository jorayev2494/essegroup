<?php

declare(strict_types=1);

namespace Project\Domains\Admin\University\Application\Faculty\Queries\Show;

use Project\Domains\Admin\University\Domain\Faculty\Exceptions\FacultyNotFoundDomainException;
use Project\Domains\Admin\University\Domain\Faculty\FacultyRepositoryInterface;
use Project\Domains\Admin\University\Domain\Faculty\FacultyTranslate;
use Project\Domains\Admin\University\Domain\Faculty\ValueObjects\Uuid;
use Project\Shared\Domain\Bus\Query\QueryHandlerInterface;

readonly class QueryHandler implements QueryHandlerInterface
{
    public function __construct(
        private FacultyRepositoryInterface $facultyRepository,
    )
    {

    }

    public function __invoke(Query $query): array
    {
        $faculty = $this->facultyRepository->findByUuid(Uuid::fromValue($query->uuid));

        $faculty ?? throw new FacultyNotFoundDomainException();

        return FacultyTranslate::execute($faculty)->toArrayWithTranslations();
    }
}
