<?php

declare(strict_types=1);

namespace Project\Domains\Student\Language\Domain\Language\Services\Contracts;

use Project\Domains\Student\Language\Application\Language\Queries\List\Query;

interface LanguageServiceInterface
{
    public function list(Query $query): array;
}
