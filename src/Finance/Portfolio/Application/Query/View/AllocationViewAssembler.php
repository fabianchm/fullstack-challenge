<?php

namespace Finizens\Finance\Portfolio\Application\Query\View;

use Finizens\Finance\Portfolio\Domain\Allocation;

final class AllocationViewAssembler
{
    public function invoke(Allocation $aggregateRoot): AllocationView
    {
        return new AllocationView(
            $aggregateRoot->id(),
            $aggregateRoot->shares()
        );   
    }
}
