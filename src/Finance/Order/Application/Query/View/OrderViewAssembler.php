<?php

declare(strict_types=1);

namespace Finizens\Finance\Order\Application\Query\View;

use Finizens\Finance\Order\Domain\Order;

final class OrderViewAssembler
{
    public function invoke(Order $order): OrderView
    {
        return new OrderView(
            id: $order->id(),
            portfolio: $order->portfolio(),
            allocation: $order->allocation(),
            shares: $order->shares(),
            type: $order->type(),
            completed: $order->completed()
        );
    }
}
