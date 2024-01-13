<?php

declare(strict_types=1);

namespace Project\Shared\Domain\Aggregate;

use Project\Shared\Contracts\ArrayableInterface;
use Project\Shared\Domain\Bus\Event\DomainEvent;

abstract class AggregateRoot implements ArrayableInterface
{
    private array $domainEvents = [];

    public function pullDomainEvents(): iterable
    {
        $domainEvents = $this->domainEvents;
        $this->domainEvents = [];

        return $domainEvents;
    }

    public function record(DomainEvent $domainEvent): void
    {
        $this->domainEvents[] = $domainEvent;
    }
}
