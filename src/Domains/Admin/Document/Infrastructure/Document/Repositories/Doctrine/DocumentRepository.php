<?php

declare(strict_types=1);

namespace Project\Domains\Admin\Document\Infrastructure\Document\Repositories\Doctrine;

use Project\Domains\Admin\Document\Application\Document\Queries\Index\Query;
use Project\Domains\Admin\Document\Application\Document\Queries\List\Query as ListQuery;
use Project\Domains\Admin\Document\Domain\Document\Document;
use Project\Domains\Admin\Document\Domain\Document\DocumentCollection;
use Project\Domains\Admin\Document\Domain\Document\DocumentRepositoryInterface;
use Project\Domains\Admin\Document\Domain\Document\ValueObjects\Uuid;
use Project\Shared\Infrastructure\Repository\Contracts\BaseAdminEntityRepository;
use Project\Shared\Infrastructure\Repository\Doctrine\Paginator;

class DocumentRepository extends BaseAdminEntityRepository implements DocumentRepositoryInterface
{

    protected function getEntity(): string
    {
        return Document::class;
    }

    public function paginate(Query $httpQuery): Paginator
    {
        $query = $this->entityRepository->createQueryBuilder('d');

        return $this->paginator($query, $httpQuery->paginator);
    }

    public function list(ListQuery $httpQuery): DocumentCollection
    {
        $query = $this->entityRepository->createQueryBuilder('d');

        $query->where('d.isActive = :isActive')
            ->setParameter('isActive', true);

        $query->orderBy('d.createdAt', 'DESC');

        return new DocumentCollection($query->getQuery()->getResult());
    }

    public function findByUuid(Uuid $uuid): ?Document
    {
        return $this->entityRepository->find($uuid);
    }

    public function save(Document $document): void
    {
        $this->entityRepository->getEntityManager()->persist($document);
        $this->entityRepository->getEntityManager()->flush();
    }

    public function delete(Document $document): void
    {
        $this->entityRepository->getEntityManager()->remove($document);
        $this->entityRepository->getEntityManager()->flush();
    }
}
