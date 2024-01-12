<?php

namespace Project\Shared\Infrastructure\Repository\Contracts;

use Project\Shared\Infrastructure\Repository\Contracts\BoundedContexts\ClientEntityManagerInterface;
use Project\Shared\Infrastructure\Repository\Doctrine\BaseEntityRepository;

abstract class BaseClientEntityRepository extends BaseEntityRepository
{
    protected function __construct(ClientEntityManagerInterface $entityManager)
    {
        parent::__construct($entityManager);
    }
}
