<?php

declare(strict_types=1);

namespace Finizens\Shared\Domain\Aggregate;

use Finizens\Shared\Domain\Event\DomainEvent;

abstract class DataSourceRoot implements AggregateRoot
{
    private array $domainEvents = [];

    final public function pullDomainEvents(): array
    {
        $domainEvents = $this->domainEvents;
        $this->domainEvents = [];

        return $domainEvents;
    }

    final protected function record(DomainEvent $domainEvent): void
    {
        $this->domainEvents[] = $domainEvent;
    }
}
