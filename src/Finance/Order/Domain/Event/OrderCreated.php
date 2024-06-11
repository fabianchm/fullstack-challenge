<?php

declare(strict_types=1);

namespace Finizens\Finance\Order\Domain\Event;

use Finizens\Shared\Domain\Event\DomainEvent;

class OrderCreated implements DomainEvent 
{
    public function __construct(
        public int $id,
        public int $portfolio,
        public int $allocation,
        public int $shares,
        public string $type,
        public bool $completed,
    ) {
    }
}
