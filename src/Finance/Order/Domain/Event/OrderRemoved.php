<?php

declare(strict_types=1);

namespace Finizens\Finance\Order\Domain\Event;

use Finizens\Shared\Domain\Event\DomainEvent;

class OrderRemoved implements DomainEvent 
{
    public function __construct(public int $id) {
    }
}
