<?php

namespace Finizens\Finance\Portfolio\Infrastructure\Listener;

use Finizens\Finance\Order\Domain\Event\OrderCompleted;
use Finizens\Finance\Portfolio\Application\Command\UpdatePortfolioAllocationsFromOrderCompleted\PortfolioAllocationUpdate; 
use Finizens\Shared\Application\MessageHandler\DomainEventListener;
use Symfony\Component\Messenger\MessageBusInterface;

final class UpdatePortfolioAllocationOnOrderCompleted implements DomainEventListener
{
    public function __construct(private MessageBusInterface $bus)
    {
    }

    public function __invoke(OrderCompleted $event): void
    {
        $this->bus->dispatch(
            new PortfolioAllocationUpdate(
                portfolioId: $event->portfolio,
                allocationId: $event->allocation,
                orderType: $event->orderType,
                shares: $event->shares
            )
        ); 
    }
}
