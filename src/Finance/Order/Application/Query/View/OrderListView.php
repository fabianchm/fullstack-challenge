<?php

declare(strict_types=1);

namespace Finizens\Finance\Order\Application\Query\View;

final class OrderListView
{
    public function __construct(public array $orders) 
    {
    }
}
