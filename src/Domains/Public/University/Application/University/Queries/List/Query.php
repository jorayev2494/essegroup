<?php

declare(strict_types=1);

namespace Project\Domains\Public\University\Application\University\Queries\List;

use Project\Domains\Admin\University\Infrastructure\University\Filters\QueryFilter;
use Project\Shared\Domain\Bus\Query\BaseHttpQueryParams;
use Symfony\Component\HttpFoundation\Request as SymfonyRequest;

readonly class Query extends BaseHttpQueryParams
{
    public ?int $limit;

    public QueryFilter $filters;

    protected function fromRequest(SymfonyRequest $request): static
    {
        $this->limit = $request->query->getInt('limit', ) ?: null;
        $this->filters = QueryFilter::makeFromRequest($request);

        return $this;
    }

    protected function fromArray(array $data): static
    {
        $this->limit = $data['limit'] ?? null;
        $this->filters = QueryFilter::makeFromArray($data);

        return $this;
    }

    public function toArray(): array
    {
        return [
            'limit' => $this->limit,
            ...$this->filters->toArray(),
        ];
    }
}
