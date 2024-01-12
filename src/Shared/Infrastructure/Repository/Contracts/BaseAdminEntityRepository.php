<?php

namespace Project\Shared\Infrastructure\Repository\Contracts;

use Project\Shared\Infrastructure\Repository\Contracts\BoundedContexts\AdminEntityManagerInterface;
use Project\Shared\Infrastructure\Repository\Doctrine\BaseEntityRepository;

abstract class BaseAdminEntityRepository extends BaseEntityRepository
{
    public function __construct(AdminEntityManagerInterface $entityManager)
    {
        // dd($entityManager);
        parent::__construct($entityManager);
    }
}
