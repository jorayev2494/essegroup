<?php

declare(strict_types=1);

namespace Project\Domains\Admin\Student\Infrastructure\Student\Repositories\Doctrine\Generators;

use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Id\AbstractIdGenerator;

//https://robbert.rocks/creating-unique-numbering-sequences-for-a-supplier
class IdentityGenerator extends AbstractIdGenerator
{

    public function generateId(EntityManagerInterface $em, ?object $entity): int
    {
        dd($em, $entity);
        $table = $em->getClassMetadata($entity::class)->getTableName();
        dd(
            $em,
            $entity,
            $table,
        );
        $maxId = $em->getConnection()->createQueryBuilder()
            ->select('MAX(identity)')
            ->from($table)
            ->executeQuery()
            ->fetchOne();

        return is_null($maxId) ? 10000 : $maxId + 1;
    }
}
