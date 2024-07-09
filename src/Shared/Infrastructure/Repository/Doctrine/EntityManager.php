<?php

declare(strict_types=1);

namespace Project\Shared\Infrastructure\Repository\Doctrine;

use Project\Shared\Infrastructure\Repository\Contracts\BoundedContexts\{AdminEntityManagerInterface,
    ClientEntityManagerInterface,
    CompanyEntityManagerInterface};

class EntityManager extends \Doctrine\ORM\EntityManager implements AdminEntityManagerInterface, CompanyEntityManagerInterface, ClientEntityManagerInterface
{

}
