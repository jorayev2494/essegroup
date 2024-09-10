<?php

declare(strict_types=1);

namespace Project\Domains\Admin\University\Infrastructure\Repositories\Doctrine\University;

use Project\Domains\Admin\University\Application\University\Queries\Index\Query as IndexQuery;
use Project\Domains\Admin\University\Application\University\Queries\List\Query as ListQuery;
use Project\Domains\Admin\University\Domain\University\UniversityCollection;
use Project\Domains\Admin\University\Domain\University\University;
use Project\Domains\Admin\University\Domain\University\UniversityRepositoryInterface;
use Project\Domains\Admin\University\Domain\University\UniversityTranslate;
use Project\Domains\Admin\University\Domain\University\ValueObjects\Uuid;
use Project\Domains\Admin\University\Infrastructure\Repositories\Doctrine\University\Filter\FilterPipelineDTO;
use Project\Domains\Admin\University\Infrastructure\Repositories\Doctrine\University\Filter\FilterQueryBuilder;
use Project\Domains\Admin\University\Infrastructure\Repositories\Doctrine\University\Search\SearchQueryBuilder;
use Project\Domains\Admin\University\Infrastructure\University\Filters\QueryFilter;
use Project\Shared\Infrastructure\Filters\BaseSearch;
use Project\Shared\Infrastructure\Repository\Contracts\BaseAdminEntityRepository;
use Project\Shared\Infrastructure\Repository\Doctrine\Paginator;
use Project\Shared\Infrastructure\Repository\Doctrine\PaginatorHttpQueryParams;
use Project\Shared\Infrastructure\Repository\Doctrine\Search\SearchPipelineSendDTO;

class UniversityRepository extends BaseAdminEntityRepository implements UniversityRepositoryInterface
{

    #[\Override]
    protected function getEntity(): string
    {
        return University::class;
    }

    public function get(): UniversityCollection
    {
        return (new UniversityCollection($this->entityRepository->findAll()))->translateItems();
    }

    public function paginate(IndexQuery $httpQuery): Paginator
    {
        $query = $this->entityRepository->createQueryBuilder('u');

        return $this->paginator($query->getQuery(), $httpQuery->paginator);
    }

    public function list(ListQuery $httpQuery): UniversityCollection
    {
        $query = $this->entityRepository->createQueryBuilder('u');

        FilterQueryBuilder::build(
            new FilterPipelineDTO(
                $query,
                $httpQuery->httpQueryFilter
            )
        );

        $query->setMaxResults($httpQuery->limit);

        if ($httpQuery->httpQueryFilter->topPosition) {
            $query->orderBy('u.topPosition', 'ASC');
            $query->addOrderBy('u.createdAt', 'ASC');
        }

        return new UniversityCollection($query->getQuery()->getResult());
    }

    public function search(PaginatorHttpQueryParams $queryParams, BaseSearch $search, QueryFilter $queryFilter): Paginator
    {
        $query = $this->entityRepository->createQueryBuilder('u');

        SearchQueryBuilder::build(
            new SearchPipelineSendDTO(
                $query,
                $search
            )
        );

        FilterQueryBuilder::build(
            new FilterPipelineDTO(
                $query,
                $queryFilter
            )
        );

        return $this->paginator($query->groupBy('u.uuid'), $queryParams);
    }

    #[\Override]
    public function findByUuid(Uuid $uuid): ?University
    {
        /** @var University $university */
        $university = $this->entityRepository->find($uuid);

        return UniversityTranslate::execute($university);
    }

    #[\Override]
    public function save(University $university): void
    {
        $this->entityRepository->getEntityManager()->persist($university);
        $this->entityRepository->getEntityManager()->flush();
    }

    #[\Override]
    public function delete(University $university): void
    {
        $this->entityRepository->getEntityManager()->remove($university);
        $this->entityRepository->getEntityManager()->flush();
    }
}
