<?php

declare(strict_types=1);

namespace Project\Domains\Admin\Language\Domain\Language;

use Project\Domains\Admin\Language\Applications\Language\Queries\Index\Query;
use Project\Domains\Admin\Language\Domain\Language\ValueObjects\Uuid;
use Project\Shared\Infrastructure\Repository\Doctrine\Paginator;

interface LanguageRepositoryInterface
{
    public function paginate(Query $httpQuery): Paginator;

    public function list(): LanguageCollection;

    public function findByUuid(Uuid $uuid): ?Language;

    public function save(Language $language): void;

    public function delete(Language $language): void;
}
