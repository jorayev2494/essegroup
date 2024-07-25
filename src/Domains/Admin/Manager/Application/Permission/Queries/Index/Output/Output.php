<?php

declare(strict_types=1);

namespace Project\Domains\Admin\Manager\Application\Permission\Queries\Index\Output;

use Project\Shared\Infrastructure\Repository\Doctrine\Paginator;

readonly class Output
{
    private function __construct(
        private Paginator $paginator
    )
    { }

    public static function make(Paginator $paginator): self
    {
        return new self($paginator);
    }

    public function toResponse(): array
    {
        return $this->paginator->map(PermissionOutput::make(...))->toArray();
    }
}