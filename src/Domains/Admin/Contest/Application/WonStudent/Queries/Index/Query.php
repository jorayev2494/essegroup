<?php

declare(strict_types=1);

namespace Project\Domains\Admin\Contest\Application\WonStudent\Queries\Index;

use Project\Shared\Domain\Bus\Query\BaseHttpQueryParams;
use Project\Shared\Infrastructure\Repository\Doctrine\PaginatorHttpQueryParams;
use Symfony\Component\HttpFoundation\Request as SymfonyRequest;

readonly class Query extends BaseHttpQueryParams
{
    private string $contestUuid;

    public PaginatorHttpQueryParams $paginator;

    protected function fromRequest(SymfonyRequest $request): static
    {
        $this->paginator = PaginatorHttpQueryParams::makeFromRequest($request);

        return $this;
    }

    protected function fromArray(array $data): static
    {
        $this->paginator = PaginatorHttpQueryParams::makeFromArray($data);

        return $this;
    }

    public function setContestUuid(string $contestUuid): self
    {
        $this->contestUuid = $contestUuid;

        return $this;
    }

    public function getContestUuid(): string
    {
        return $this->contestUuid;
    }

    public function toArray(): array
    {
        return [

        ];
    }
}
