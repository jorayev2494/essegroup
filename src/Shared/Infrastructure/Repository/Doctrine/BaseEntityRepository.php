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
        if ($entityName = $this->getEntity()) {
            $this->entityRepository = $entityManager->getRepository($entityName);
        }
    }

    abstract protected function getEntity(): string;
}
