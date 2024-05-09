<?php

declare(strict_types=1);

namespace Project\Shared\Infrastructure\Filters;

use Project\Shared\Contracts\ArrayableInterface;
use Project\Shared\Domain\Bus\Query\BaseHttpQueryParams;
use Symfony\Component\HttpFoundation\Request as SymfonyRequest;

readonly class BaseSearch extends BaseHttpQueryParams implements ArrayableInterface
{
    public ?string $search;

    public ?string $searchBy;

    protected function fromRequest(SymfonyRequest $request): static
    {
        $this->search = $request->get('search');
        $this->searchBy = $request->get('search_by');

        return $this;
    }

    protected function fromArray(array $data): static
    {
        $this->search = $data['search'] ?? null;
        $this->searchBy = $data['search_by'] ?? null;

        return $this;
    }

    /**
     * @inheritDoc
     */
    public function toArray(): array
    {
        return [
            'search' => $this->search,
            'search_by' => $this->searchBy,
        ];
    }
}
