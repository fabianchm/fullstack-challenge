<?php

namespace Finizens\Finance\Portfolio\Application\Query\View;

use Finizens\Finance\Portfolio\Domain\Allocation;
use Finizens\Finance\Portfolio\Domain\Portfolio;

final class PortfolioViewAssembler
{
    public function __construct(private AllocationViewAssembler $allocationAssembler)
    {
    }

    public function invoke(Portfolio $aggregateRoot): PortfolioView
    {
        return new PortfolioView(
            $aggregateRoot->id(),
            array_values(
                array_map(
                    fn(Allocation $allocation) => $this->allocationAssembler->invoke($allocation),
                    $aggregateRoot->allocations()
                )
            )
        ); 
    }
}
