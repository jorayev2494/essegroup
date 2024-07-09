<?php

namespace Project\Domains\Admin\University\Domain\Faculty\Name;

use Project\Domains\Admin\University\Application\Faculty\Name\Queries\Index\Query;
use Project\Domains\Admin\University\Domain\Faculty\Name\ValueObjects\Uuid;
use Project\Shared\Infrastructure\Repository\Doctrine\Paginator;

interface FacultyNameRepositoryInterface
{
    public function paginate(Query $httpQuery): Paginator;

    public function list(): FacultyNameCollection;

    public function findByUuid(Uuid $uuid): ?FacultyName;

    public function save(FacultyName $name): void;

    public function delete(FacultyName $name): void;
}
