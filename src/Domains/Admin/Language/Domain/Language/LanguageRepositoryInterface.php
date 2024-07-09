<?php

declare(strict_types=1);

namespace Project\Domains\Admin\Language\Domain\Language;

use Project\Domains\Admin\Language\Applications\Language\Queries\Index\Query as IndexQuery;
use Project\Domains\Admin\Language\Applications\Language\Queries\List\Query as ListQuery;
use Project\Domains\Admin\Language\Domain\Language\ValueObjects\Uuid;
use Project\Shared\Infrastructure\Repository\Doctrine\Paginator;

interface LanguageRepositoryInterface
{
    public function paginate(IndexQuery $httpQuery): Paginator;

    public function list(ListQuery $httpQuery): LanguageCollection;

    public function findByUuid(Uuid $uuid): ?Language;

    public function save(Language $language): void;

    public function delete(Language $language): void;
}
