<?php

declare(strict_types=1);

namespace Finizens\Finance\Order\Application\Command\UpdateOrderCompleted;

use Finizens\Finance\Order\Domain\OrderRepository;
use Finizens\Shared\Application\MessageHandler\CommandHandler;
use Symfony\Component\Messenger\MessageBusInterface;

class UpdateOrderCompletedHandler implements CommandHandler
{
    public function __construct(
        private OrderRepository $repository,
        private MessageBusInterface $eventBus,
    ) {
    }

    public function __invoke(UpdateOrderCompleted $command): void
    {
        $order = $this->repository->searchByPortfolioId($command->id);

        if ($command->status !== "completed") {
            # Throw 400 exception
        }

        if ($order->completed() === true) {
            return;
        }
        
        $order->markAsCompleted();

        $this->repository->save($order);
 
        $this->eventBus->dispatch(...$order->pullDomainEvents());
    }
}
