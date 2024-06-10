<?php

declare(strict_types=1);

namespace Project\Domains\Admin\University\Application\ApplicationStatusValue\Queries\WidgetList;

use Project\Domains\Admin\University\Infrastructure\Application\Filters\StatusValueQueryFilter;
use Project\Shared\Domain\Bus\Query\BaseHttpQueryParams;
use Symfony\Component\HttpFoundation\Request as SymfonyRequest;

readonly class Query extends BaseHttpQueryParams
{
    public StatusValueQueryFilter $filter;

    protected function fromRequest(SymfonyRequest $request): static
    {
        $this->filter = StatusValueQueryFilter::makeFromRequest($request);

        return $this;
    }

    protected function fromArray(array $data): static
    {
        $this->filter = StatusValueQueryFilter::makeFromArray($data);

        return $this;
    }

    public function toArray(): array
    {
        return [
            ...$this->filter->toArray(),
        ];
    }
}
