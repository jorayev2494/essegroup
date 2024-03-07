<?php

namespace Project\Shared\Infrastructure\Repository\Contracts;

use Project\Shared\Infrastructure\Repository\Contracts\BoundedContexts\CompanyEntityManagerInterface;
use Project\Shared\Infrastructure\Repository\Doctrine\BaseEntityRepository;

abstract class BaseCompanyEntityRepository extends BaseEntityRepository
{
    public function __construct(CompanyEntityManagerInterface $entityManager)
    {
        parent::__construct($entityManager);
    }
}
