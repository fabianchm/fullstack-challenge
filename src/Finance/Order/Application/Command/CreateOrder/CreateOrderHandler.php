<?php

declare(strict_types=1);

namespace Finizens\Finance\Order\Application\Command\CreateOrder;

use Finizens\Finance\Order\Domain\Order;
use Finizens\Finance\Order\Domain\OrderRepository;
use Finizens\Finance\Shared\Application\Query\SearchAllocationById;
use Finizens\Finance\Shared\Domain\OrderTypeEnum;
use Finizens\Shared\Application\MessageHandler\CommandHandler;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Messenger\Stamp\HandledStamp;

class CreateOrderHandler implements CommandHandler
{
    public function __construct(
        private OrderRepository $repository,
        private MessageBusInterface $eventBus,
        private MessageBusInterface $queryBus
    ) {
    }

    public function __invoke(CreateOrder $command): void
    {
        $this->validateData($command);
        $this->validateAggregate($command->portfolio, $command->allocation, $command->shares, $command->type);

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

    private function validateData(CreateOrder $command): void
    {
        if ($command->id === null 
            || $command->portfolio === null 
            || $command->allocation === null 
            || $command->shares === null 
            || $command->type === null
        ) {
            throw new HttpException(statusCode: 400);
        }
    }

    private function validateAggregate(int $portfolio, int $allocation, int $shares, string $type): void
    {
        $response = $this->queryBus->dispatch(new SearchAllocationById($portfolio, $allocation)); 
        $allocation = $response->last(HandledStamp::class)->getResult();

        if ($type === OrderTypeEnum::SELL && $allocation->shares() < $shares) {
            throw new HttpException(statusCode: 500);
        }
    }
}
