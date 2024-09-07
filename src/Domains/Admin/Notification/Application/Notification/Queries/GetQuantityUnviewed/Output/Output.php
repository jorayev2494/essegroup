<?php

declare(strict_types=1);

namespace Project\Domains\Admin\Notification\Application\Notification\Queries\GetQuantityUnviewed\Output;

readonly class Output
{
    public function __construct(
        private int $quantityUnviewed
    ) { }

    public static function make(int $quantityUnviewed): self
    {
        return new self($quantityUnviewed);
    }

    public function toResponse(): array
    {
        return [
            'quantity_unviewed' => $this->quantityUnviewed,
        ];
    }
}