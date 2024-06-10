<?php

namespace Finizens\Finance\Portfolio\Application\Query\View;

final class PortfolioView
{
    public function __construct(
        public int $id,
        public array $allocations
    ) {
    }
}
