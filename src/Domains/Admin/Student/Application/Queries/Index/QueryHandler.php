<?php

declare(strict_types=1);

namespace Project\Domains\Admin\Student\Application\Queries\Index;

use Project\Domains\Admin\Country\Domain\Country\CountryTranslate;
use Project\Domains\Admin\Language\Domain\Language\LanguageTranslate;
use Project\Domains\Admin\Student\Domain\Student\Student;
use Project\Domains\Admin\Student\Domain\Student\StudentRepositoryInterface;
use Project\Domains\Admin\University\Domain\Application\Application;
use Project\Domains\Admin\University\Domain\Application\StatusTranslate;
use Project\Domains\Admin\University\Domain\Degree\DegreeTranslate;
use Project\Domains\Admin\University\Domain\Department\Department;
use Project\Domains\Admin\University\Domain\Department\DepartmentTranslate;
use Project\Domains\Admin\University\Domain\University\UniversityTranslate;
use Project\Shared\Domain\Bus\Query\QueryHandlerInterface;

readonly class QueryHandler implements QueryHandlerInterface
{
    public function __construct(
        private StudentRepositoryInterface $repository
    ) { }

    public function __invoke(Query $query): array
    {
        return $this->repository->paginate($query)->map(fn (Student $student): array => [
            ...$student->toArray(),
            'applications' => $student->getApplications()->map($this->applicationMapper())->toArray(),
        ])->toArray();
    }

    private function applicationMapper(): \Closure
    {
        return fn (Application $application): array => [
            'uuid' => $application->getUuid()->value,
            'language' => LanguageTranslate::execute($application->getLanguage())?->toArray(),
            'degree' => [
                'uuid' => $application->getDegree()->getUuid()->value,
                'value' => DegreeTranslate::execute($application->getDegree())->getValue()->value,
            ],
            'country' => CountryTranslate::execute($application->getCountry())?->toArray(),
            'university' => [
                'uuid' => $application->getUniversity()->isNotNull() ? $application->getUniversity()->getUuid()->value : null,
                'name' => UniversityTranslate::execute($application->getUniversity())?->getName()->value,
                'logo' => $application->getUniversity()->isNotNull() ? $application->getUniversity()->getLogo()->toArray() : null,
            ],
            'departments' => array_map(
                $this->departmentMapper(),
                iterator_to_array($application->getDepartments())
            ),
            'status' => StatusTranslate::execute($application->getStatus())->toArray(),
        ];
    }

    private function departmentMapper(): \Closure
    {
        return static fn (Department $department): array => [
            'uuid' => $department->getUuid()->value,
            'name' => DepartmentTranslate::execute($department)?->getName()?->toArray(),
        ];
    }
}
