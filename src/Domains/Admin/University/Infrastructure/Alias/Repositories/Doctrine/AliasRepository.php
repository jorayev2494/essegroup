<?php

declare(strict_types=1);

namespace Project\Domains\Admin\University\Infrastructure\Alias\Repositories\Doctrine;

use Project\Domains\Admin\University\Application\Alias\Queries\Index\Query as IndexQuery;
use Project\Domains\Admin\University\Application\Alias\Queries\List\Query as ListQuery;
use Project\Domains\Admin\University\Domain\Alias\Alias;
use Project\Domains\Admin\University\Domain\Alias\AliasCollection;
use Project\Domains\Admin\University\Domain\Alias\AliasRepositoryInterface;
use Project\Domains\Admin\University\Domain\Alias\ValueObjects\Uuid;
use Project\Domains\Admin\University\Infrastructure\Alias\Repositories\Doctrine\Filter\FilterPipelineDTO;
use Project\Domains\Admin\University\Infrastructure\Alias\Repositories\Doctrine\Filter\FilterQueryBuilder;
use Project\Shared\Infrastructure\Repository\Contracts\BaseAdminEntityRepository;
use Project\Shared\Infrastructure\Repository\Doctrine\Paginator;

class AliasRepository extends BaseAdminEntityRepository implements AliasRepositoryInterface
{
    protected function getEntity(): string
    {
        return Alias::class;
    }

    public function paginate(IndexQuery $httpQuery): Paginator
    {
        $query = $this->entityRepository->createQueryBuilder('a');

        return $this->paginator($query, $httpQuery->paginator);
    }

    public function list(ListQuery $httpQuery): AliasCollection
    {
        $query = $this->entityRepository->createQueryBuilder('a');

        FilterQueryBuilder::build(
            new FilterPipelineDTO(
                $query,
                $httpQuery->filter
            )
        );

        return new AliasCollection($query->getQuery()->getResult());
    }

    public function findByUuid(Uuid $uuid): ?Alias
    {
        return $this->entityRepository->find($uuid);
    }

    public function save(Alias $alias): void
    {
        $this->entityRepository->getEntityManager()->persist($alias);
        $this->entityRepository->getEntityManager()->flush();
    }

    public function delete(Alias $alias): void
    {
        $this->entityRepository->getEntityManager()->remove($alias);
        $this->entityRepository->getEntityManager()->flush();
    }
}
