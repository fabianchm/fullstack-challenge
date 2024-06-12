<?php

namespace Finizens\Finance\Order\Infrastructure\Listener;

use Finizens\Finance\Order\Application\Command\RemoveOrder\RemoveOrder;
use Finizens\Finance\Order\Domain\OrderRepository;
use Finizens\Finance\Shared\Domain\PortfolioReset;
use Finizens\Shared\Application\MessageHandler\DomainEventListener;
use Symfony\Component\Messenger\MessageBusInterface;

final class RemovePortfolioOrdersOnPortfolioReset implements DomainEventListener
{
    public function __construct(
        private MessageBusInterface $bus,
        private OrderRepository $repository
    ) {
    }

    public function __invoke(PortfolioReset $event): void
    {
        $orders = $this->repository->searchAllByPortfolioId($event->id);

        foreach ($orders as $order) {
            $this->bus->dispatch(
                new RemoveOrder($order->id())
            );
        }
    }
}
