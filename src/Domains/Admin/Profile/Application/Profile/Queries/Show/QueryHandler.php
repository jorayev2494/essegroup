<?php

declare(strict_types=1);

namespace Project\Domains\Admin\Profile\Application\Profile\Queries\Show;

use Project\Domains\Admin\Profile\Domain\Services\Contracts\ProfileServiceInterface;
use Project\Shared\Domain\Bus\Query\QueryHandlerInterface;

readonly class QueryHandler implements QueryHandlerInterface
{
    public function __construct(
        public ProfileServiceInterface $service
    ) { }

    public function __invoke(Query $query): array
    {
        return $this->service->show();
    }
}
