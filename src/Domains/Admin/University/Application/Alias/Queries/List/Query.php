<?php

declare(strict_types=1);

namespace Project\Domains\Admin\University\Application\Alias\Queries\List;

use Project\Shared\Domain\Bus\Query\BaseHttpQueryParams;
use Symfony\Component\HttpFoundation\Request as SymfonyRequest;

readonly class Query extends BaseHttpQueryParams
{
    protected function fromRequest(SymfonyRequest $request): static
    {
        return $this;
    }

    protected function fromArray(array $data): static
    {
        return $this;
    }

    public function toArray(): array
    {
        return [

        ];
    }
}
