<?php

namespace Finizens\Finance\Shared\Domain;

use Finizens\Shared\Domain\Event\DomainEvent;

final class PortfolioReset implements DomainEvent
{
    public function __construct(public int $id)
    {
    }
}
