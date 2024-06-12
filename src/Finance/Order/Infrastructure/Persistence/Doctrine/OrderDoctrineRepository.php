<?php

declare(strict_types=1);

namespace Finizens\Finance\Order\Infrastructure\Persistence\Doctrine;

use Finizens\Finance\Order\Domain\Order;
use Finizens\Finance\Order\Domain\OrderRepository;
use Finizens\Shared\Infrastructure\Persistence\Doctrine\DoctrineRepository;

final class OrderDoctrineRepository extends DoctrineRepository implements OrderRepository
{
    public function entityClassName(): string
    {
        return Order::class;
    }

    public function save(Order $order): void
    {
        $this->persistAggregateRoot($order);
    }

    public function searchById(int $id): ?Order
    {
        return $this->repository()->findOneBy(['id' => $id]);
    }
}
