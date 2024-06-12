<?php

namespace Finizens\Finance\Portfolio\Application\Command\UpdatePortfolioAllocationsFromOrderCompleted;

use Finizens\Shared\Application\MessageHandler\Command;

final class UpdatePortfolioAllocation implements Command
{
    public function __construct(
        public int $portfolioId,
        public int $allocationId,
        public int $shares,
        public string $orderType,
    ) {
    }
}
