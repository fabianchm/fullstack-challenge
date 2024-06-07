<?php

declare(strict_types=1);

namespace Finizens\Finance\Portfolio\Domain\Event;

use Finizens\Shared\Domain\Event\DomainEvent;

class PortfolioCreated implements DomainEvent 
{
    public function __construct(public int $id)
    {
    }
}
