<?php

declare(strict_types=1);

namespace Project\Domains\Company\Language\Application\Language\Queries\List;

use Project\Domains\Company\Language\Domain\Language\Services\Contracts\LanguageServiceInterface;
use Project\Shared\Domain\Bus\Query\QueryHandlerInterface;

readonly class QueryHandler implements QueryHandlerInterface
{
    public function __construct(
        private LanguageServiceInterface $service
    ) { }

    public function __invoke(Query $query): array
    {
        return $this->service->list($query);
    }
}
