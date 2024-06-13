<?php

declare(strict_types=1);

namespace Finizens\Finance\Order\Application\Query\View;

use Finizens\Finance\Order\Domain\Order;

final class OrderListViewAssembler
{
    public function __construct(private OrderViewAssembler $viewAssembler)
    {
    }

    public function invoke(array $orderList): OrderListView
    {
        $list = array_map(
            function (Order $order): OrderView
            {
                return $this->viewAssembler->invoke($order);
            },
            $orderList
        );

        return new OrderListView($list);
    }
}
