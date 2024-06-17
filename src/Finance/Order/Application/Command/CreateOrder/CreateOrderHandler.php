<?php

declare(strict_types=1);

namespace Finizens\Finance\Order\Application\Command\CreateOrder;

use Exception;
use Finizens\Finance\Order\Domain\Order;
use Finizens\Finance\Order\Domain\OrderRepository;
use Finizens\Shared\Application\MessageHandler\CommandHandler;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Symfony\Component\Messenger\MessageBusInterface;

class CreateOrderHandler implements CommandHandler
{
    public function __construct(
        private OrderRepository $repository,
        private MessageBusInterface $eventBus,
    ) {
    }

    public function __invoke(CreateOrder $command): void
    {
        $this->validate($command);

        $order = Order::create(
            $command->id,
            $command->portfolio,
            $command->allocation,
            $command->shares,
            $command->type 
        );

        $this->repository->save($order);
 
        $this->eventBus->dispatch(...$order->pullDomainEvents());
    }

    private function validate(CreateOrder $command): void
    {
        if ($command->id === null 
            || $command->portfolio === null 
            || $command->allocation === null 
            || $command->shares === null 
            || $command->type === null
        ) {
            throw new Exception(code: 400);
        }
    }
}
