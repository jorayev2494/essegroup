<?php

declare(strict_types=1);

namespace Project\Domains\Admin\Language\Infrastructure\Language\Repositories\Doctrine;

use Project\Domains\Admin\Language\Applications\Language\Queries\Index\Query as IndexQuery;
use Project\Domains\Admin\Language\Applications\Language\Queries\List\Query as ListQuery;
use Project\Domains\Admin\Language\Domain\Language\Language;
use Project\Domains\Admin\Language\Domain\Language\LanguageCollection;
use Project\Domains\Admin\Language\Domain\Language\LanguageRepositoryInterface;
use Project\Domains\Admin\Language\Domain\Language\ValueObjects\Uuid;
use Project\Domains\Admin\Language\Infrastructure\Language\Repositories\Doctrine\Filter\FilterQueryBuilder;
use Project\Shared\Infrastructure\Repository\Contracts\BaseAdminEntityRepository;
use Project\Domains\Admin\Language\Infrastructure\Language\Repositories\Doctrine\Filter\FilterPipelineDTO;
use Project\Shared\Infrastructure\Repository\Doctrine\Paginator;

class LanguageRepository extends BaseAdminEntityRepository implements LanguageRepositoryInterface
{

    protected function getEntity(): string
    {
        return Language::class;
    }

    public function paginate(IndexQuery $httpQuery): Paginator
    {
        $query = $this->entityRepository->createQueryBuilder('l');

        return $this->paginator($query, $httpQuery->paginator);
    }

    public function list(ListQuery $httpQuery): LanguageCollection
    {
        $query = $this->entityRepository->createQueryBuilder('l');

        FilterQueryBuilder::build(
            new FilterPipelineDTO(
                $query,
                $httpQuery->filter
            )
        );

        return new LanguageCollection($query->getQuery()->getResult());
    }

    public function findByUuid(Uuid $uuid): ?Language
    {
        return $this->entityRepository->find($uuid);
    }

    public function save(Language $language): void
    {
        $this->entityRepository->getEntityManager()->persist($language);
        $this->entityRepository->getEntityManager()->flush();
    }

    public function delete(Language $language): void
    {
        $this->entityRepository->getEntityManager()->remove($language);
        $this->entityRepository->getEntityManager()->flush();
    }
}
