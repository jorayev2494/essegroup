<?php

declare(strict_types=1);

namespace Project\Shared\Infrastructure\Repository\Doctrine;

use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityRepository;

abstract class BaseEntityRepository extends EntityRepository
{
    protected EntityRepository $entityRepository;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->initRepository($entityManager);
    }

    private function initRepository(EntityManagerInterface $entityManager): void
    {
        $this->entityRepository = $entityManager->getRepository($this->getEntity());
    }

    abstract protected function getEntity(): string;

    protected function paginator($query, PaginatorHttpQueryParams $httpQueryParams, bool $fetchJoinCollection = true, bool $outputWalkers = true): Paginator
    {
        return new Paginator($query, $httpQueryParams, $fetchJoinCollection, $outputWalkers);
    }

    public function flush(): void
    {
        $this->entityRepository->getEntityManager()->flush();
    }
}
