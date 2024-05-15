<?php

declare(strict_types=1);

namespace Project\Domains\Admin\Student\Domain\Student;

use Project\Domains\Admin\Contest\Application\Contest\Queries\Participants\Query as GetParticipantsQuery;
use Project\Domains\Admin\Student\Application\Queries\Index\Query;
use Project\Domains\Admin\Student\Domain\Student\ValueObjects\Uuid;
use Project\Shared\Infrastructure\Repository\Doctrine\Paginator;

interface StudentRepositoryInterface
{
    public function paginate(Query $httpQuery): ?Paginator;

    public function paginateParticipants(GetParticipantsQuery $httpQuery): Paginator;

    public function getParticipants(array $applicationStatusUuids, array $studentNationalityUuids, array $wonStudentUuids = []): StudentCollection;

    public function findByUuid(Uuid $uuid): ?Student;

    public function save(Student $student): void;

    public function delete(Student $student): void;
}
