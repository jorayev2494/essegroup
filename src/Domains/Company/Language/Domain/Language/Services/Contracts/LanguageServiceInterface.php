<?php

declare(strict_types=1);

namespace Project\Domains\Company\Language\Domain\Language\Services\Contracts;

use Project\Domains\Company\Language\Application\Language\Queries\List\Query;

interface LanguageServiceInterface
{
    public function list(Query $query): array;
}
