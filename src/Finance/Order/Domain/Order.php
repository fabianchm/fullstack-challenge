<?php

declare(strict_types=1);

namespace Finizens\Finance\Order\Domain;

use Finizens\Finance\Order\Domain\Event\OrderCompleted;
use Finizens\Finance\Order\Domain\Event\OrderCreated;
use Finizens\Shared\Domain\Aggregate\DataSourceRoot;

class Order extends DataSourceRoot
{
    public function __construct(
        private int $id,
        private int $portfolio,
        private int $allocation,
        private int $shares,
        private string $type,
        private bool $completed
    ) {
    }

    public static function create(
        int $id,
        int $portfolio,
        int $allocation,
        int $shares,
        string $type,
    ): self {
        $order = new self(
            $id,
            $portfolio,
            $allocation,
            $shares,
            $type,
            false
        );
        
        $order->record(
            new OrderCreated(
                $id,
                $portfolio,
                $allocation,
                $shares,
                $type,
                false
            )
        );

        return $order;
    }

    public function completed(): bool
    {
        return $this->completed;
    }

    public function markAsCompleted(): void
    {
        $this->completed = true;

        $this->record(
            new OrderCompleted(
                id: $this->id,
                portfolio: $this->portfolio,
                allocation: $this->allocation,
                orderType: $this->type,
                shares: $this->shares 
            )
        );
    }   
}
