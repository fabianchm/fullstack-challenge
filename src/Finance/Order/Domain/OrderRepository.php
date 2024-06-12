<?php

declare(strict_types=1);

namespace Finizens\Finance\Order\Domain;

use Finizens\Finance\Order\Domain\Order;

interface OrderRepository
{
    public function save(Order $order): void;

    public function searchById(int $id): ?Order;
}
