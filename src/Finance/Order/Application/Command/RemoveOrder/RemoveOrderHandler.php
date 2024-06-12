<?php

declare(strict_types=1);

namespace Finizens\Finance\Order\Application\Command\RemoveOrder;

use Finizens\Finance\Order\Domain\OrderRepository;
use Finizens\Shared\Application\MessageHandler\CommandHandler;
use Symfony\Component\Messenger\MessageBusInterface;

class RemoveOrderHandler implements CommandHandler
{
    public function __construct(
        private OrderRepository $repository,
        private MessageBusInterface $eventBus,
    ) {
    }

    public function __invoke(RemoveOrder $command): void
    {
        $order = $this->repository->searchById($command->id);

        if ($order === null) {
            return;
        }

        $order->remove();

        $this->repository->remove($order);
 
        $this->eventBus->dispatch(...$order->pullDomainEvents());
    }
}
