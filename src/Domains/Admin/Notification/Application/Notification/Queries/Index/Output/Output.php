<?php

declare(strict_types=1);

namespace Project\Domains\Admin\Notification\Application\Notification\Queries\Index\Output;

use Doctrine\Common\Collections\ArrayCollection;
use Project\Domains\Admin\Notification\Domain\Notification\Notification;
use Project\Shared\Infrastructure\Repository\Doctrine\Paginator;

readonly class Output
{
    private function __construct(
        private Paginator $paginator,
        private ArrayCollection $viewedManagers
    ) { }

    public static function make(Paginator $paginator, ArrayCollection $viewedManagers): self
    {
        return new self($paginator, $viewedManagers);
    }

    public function toResponse(): array
    {
        return $this->paginator->map(
            fn (Notification $notification): array => NotificationOutput::make($notification, $this->viewedManagers)->toArray()
        )->toArray();
    }
}