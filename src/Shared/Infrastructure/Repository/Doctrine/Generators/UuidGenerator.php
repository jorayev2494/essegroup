<?php

declare(strict_types=1);

namespace Project\Shared\Infrastructure\Repository\Doctrine\Generators;

use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Id\AbstractIdGenerator;
use Project\Domains\Admin\Notification\Domain\CompanyNotification\ValueObjects\Uuid;

class UuidGenerator extends AbstractIdGenerator
{
    public function generateId(EntityManagerInterface $em, ?object $entity): string
    {
        return Uuid::generate()->value;
    }
}