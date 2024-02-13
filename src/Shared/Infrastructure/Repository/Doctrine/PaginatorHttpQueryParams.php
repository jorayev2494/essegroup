<?php

declare(strict_types=1);

namespace Project\Shared\Infrastructure\Repository\Doctrine;

use Symfony\Component\HttpFoundation\Request as SymfonyRequest;

readonly class PaginatorHttpQueryParams
{
    private function __construct(
        public ?int $page,
        public ?int $perPage,
        public ?string $cursor,
    )
    {

    }

    public static function make(SymfonyRequest $request): self
    {
        return new self(
            page: $request->query->getInt('page', 1),
            perPage: $request->query->getInt('per_page', 15),
            cursor: $request->query->get('cursor'),
        );
    }

}
