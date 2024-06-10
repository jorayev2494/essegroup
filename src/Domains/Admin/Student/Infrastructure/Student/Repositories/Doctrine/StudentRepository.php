<?php

declare(strict_types=1);

namespace Project\Domains\Admin\Student\Infrastructure\Student\Repositories\Doctrine;

use Doctrine\ORM\Query\Expr\Join;
use Doctrine\ORM\QueryBuilder;
use Project\Domains\Admin\Student\Application\Queries\Index\Query;
use Project\Domains\Admin\Student\Domain\Student\Student;
use Project\Domains\Admin\Student\Domain\Student\StudentCollection;
use Project\Domains\Admin\Student\Domain\Student\StudentRepositoryInterface;
use Project\Domains\Admin\Student\Domain\Student\ValueObjects\Email;
use Project\Domains\Admin\Student\Domain\Student\ValueObjects\Uuid;
use Project\Domains\Admin\University\Domain\Application\Application;
use Project\Domains\Admin\University\Domain\Application\ApplicationRepositoryInterface;
use Project\Domains\Admin\University\Domain\Application\ValueObjects\Status;
use Project\Shared\Infrastructure\Repository\Contracts\BaseAdminEntityRepository;
use Project\Shared\Infrastructure\Repository\Doctrine\Paginator;
use Project\Domains\Admin\Contest\Application\Contest\Queries\Participants\Query as GetParticipantsQuery;

class StudentRepository extends BaseAdminEntityRepository implements StudentRepositoryInterface
{
    protected function getEntity(): string
    {
        return Student::class;
    }

    public function paginate(Query $httpQuery): ?Paginator
    {
        $query = $this->entityRepository->createQueryBuilder('s');

        if ($httpQuery->search->searchBy === 'full_name' && $httpQuery->search->search !== null) {
            [$firstName] = explode(' ', $httpQuery->search->search);

            $query->andWhere("s.fullName.firstName LIKE :first_name")
                ->setParameter('first_name', '%' . $firstName . '%');

            $query->orWhere("s.fullName.lastName LIKE :last_name")
                ->setParameter('last_name', '%' . $firstName . '%');

            if (str_contains(' ', $httpQuery->search->search)) {
                [, $lastName] = explode(' ', $httpQuery->search->search);

                $query->andWhere("s.fullName.lastName LIKE :last_name")
                    ->setParameter('last_name', '%' . $lastName . '%');
            }
        }

        if (count($companyUuids = $httpQuery->filter->companyUuids) > 0) {
            $query->andWhere('s.companyUuid IN (:companyUuids)')
                ->setParameter('companyUuids', $companyUuids);
        }

        if (count($httpQuery->filter->universityUuids) > 0) {
            $query->innerJoin(Application::class, 'aa', Join::WITH, 's.uuid = aa.studentUuid');
            $query->andWhere('aa.universityUuid IN (:universityUuids)')
                ->setParameter('universityUuids', $httpQuery->filter->universityUuids);
        }

        if (count($httpQuery->filter->statusValueUuids) > 0) {
            $query->innerJoin(Application::class, 'a', Join::WITH, 's.uuid = a.studentUuid');

            $currentStatusUuids = [];

            /** @var ApplicationRepositoryInterface $applicationRepository */
            $applicationRepository = resolve(ApplicationRepositoryInterface::class);

            $applicationRepository->getApplicationCountWhereCurrentStatusAre($httpQuery->filter->statusValueUuids)
                ->forEach(static function (Application $app) use(&$currentStatusUuids): void {
                    $currentStatusUuids[] = $app->getUuid()->value;
                });

            $query->andWhere('a.uuid IN (:applicationUuids)')
                ->setParameter('applicationUuids', $currentStatusUuids);
        }

        $query->orderBy('s.createdAt', 'DESC');

        return $this->paginator($query, $httpQuery->paginator);
    }

    public function paginateParticipants(GetParticipantsQuery $httpQuery): Paginator
    {
        $query = $this->entityRepository->createQueryBuilder('s');

        $this->participantsQuery($query, $httpQuery->applicationStatusUuids, $httpQuery->studentNationalityUuids);

        return $this->paginator($query, $httpQuery->paginator);
    }

    public function getParticipants(array $applicationStatusUuids, array $studentNationalityUuids, array $wonStudentUuids = []): StudentCollection
    {
        $query = $this->entityRepository->createQueryBuilder('s');

        $this->participantsQuery($query, $applicationStatusUuids, $studentNationalityUuids, $wonStudentUuids);

        return new StudentCollection($query->getQuery()->getResult());
    }

    public function findByUuid(Uuid $uuid): ?Student
    {
        return $this->entityRepository->find($uuid);
    }

    public function save(Student $student): void
    {
        $this->entityRepository->getEntityManager()->persist($student);
        $this->entityRepository->getEntityManager()->flush();
    }

    public function delete(Student $student): void
    {
        $this->entityRepository->getEntityManager()->remove($student);
        $this->entityRepository->getEntityManager()->flush();
    }

    private function participantsQuery(QueryBuilder $query, array $applicationStatusUuids, array $studentNationalityUuids, array $wonStudentUuids = []): QueryBuilder
    {
        if (count($applicationStatusUuids) > 0) {
            $query
                ->innerJoin(Application::class, 'a', Join::WITH, 'a.studentUuid = s.uuid')
                ->innerJoin(Status::class, 'ast', Join::WITH, 'ast.applicationUuid = a.uuid');

            $query
                ->andWhere('ast.statusValueUuid IN (:applicationStatusUuids)')
                ->setParameter('applicationStatusUuids', $applicationStatusUuids);
        }

        if (count($studentNationalityUuids) > 0) {
            $query
                ->andWhere('s.nationalityUuid IN (:studentNationalityUuids)')
                ->setParameter('studentNationalityUuids', $studentNationalityUuids);
        }

        if (count($wonStudentUuids) > 0) {
            $query
                ->andWhere('s.uuid NOT IN (:wonStudentUuids)')
                ->setParameter('wonStudentUuids', $wonStudentUuids);
        }

        return $query;
    }

    public function findByEmail(Email $email): ?Student
    {
        return $this->entityRepository->createQueryBuilder('s')
            ->where('s.email = :email')
            ->setParameter('email', $email->value)
            ->getQuery()
            ->getOneOrNullResult();
    }
}
