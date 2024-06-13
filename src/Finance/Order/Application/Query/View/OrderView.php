<?php

declare(strict_types=1);

namespace Finizens\Finance\Order\Application\Query\View;

final class OrderView
{
    public function __construct(
        public int $id,
        public int $portfolio,
        public int $allocation,
        public int $shares,
        public string $type,
        public bool $completed
    ) {
    }
}
