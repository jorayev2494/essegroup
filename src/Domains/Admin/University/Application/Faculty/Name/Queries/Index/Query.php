<?php

declare(strict_types=1);

namespace Project\Domains\Admin\University\Application\Faculty\Name\Queries\Index;

use Project\Shared\Domain\Bus\Query\BaseHttpQueryParams;
use Project\Shared\Infrastructure\Repository\Doctrine\PaginatorHttpQueryParams;
use Symfony\Component\HttpFoundation\Request as SymfonyRequest;

readonly class Query extends BaseHttpQueryParams
{
    public PaginatorHttpQueryParams $paginator;

    protected function fromRequest(SymfonyRequest $request): static
    {
        $this->paginator = PaginatorHttpQueryParams::makeFromRequest($request);

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
