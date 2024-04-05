<?php

declare(strict_types=1);

namespace Project\Domains\Admin\University\Infrastructure\Repositories\Doctrine\Faculty\Name;

use Project\Domains\Admin\University\Application\Faculty\Name\Queries\Index\Query;
use Project\Domains\Admin\University\Domain\Faculty\Name\FacultyName;
use Project\Domains\Admin\University\Domain\Faculty\Name\FacultyNameCollection;
use Project\Domains\Admin\University\Domain\Faculty\Name\FacultyNameRepositoryInterface;
use Project\Domains\Admin\University\Domain\Faculty\Name\ValueObjects\Uuid;
use Project\Shared\Infrastructure\Repository\Contracts\BaseAdminEntityRepository;
use Project\Shared\Infrastructure\Repository\Doctrine\Paginator;

class FacultyNameRepository extends BaseAdminEntityRepository implements FacultyNameRepositoryInterface
{
    protected function getEntity(): string
    {
        return FacultyName::class;
    }

    public function paginate(Query $httpQuery): Paginator
    {
        $query = $this->entityRepository->createQueryBuilder('fn');

        return $this->paginator($query, $httpQuery->paginator);
    }

    public function list(): FacultyNameCollection
    {
        return new FacultyNameCollection(
            $this->entityRepository->createQueryBuilder('fn')
                ->getQuery()
                ->getResult()
        );
    }

    public function findByUuid(Uuid $uuid): ?FacultyName
    {
        return $this->entityRepository->find($uuid);
    }

    public function save(FacultyName $name): void
    {
        $this->entityRepository->getEntityManager()->persist($name);
        $this->entityRepository->getEntityManager()->flush();
    }

    public function delete(FacultyName $name): void
    {
        $this->entityRepository->getEntityManager()->remove($name);
        $this->entityRepository->getEntityManager()->flush();
    }
}
