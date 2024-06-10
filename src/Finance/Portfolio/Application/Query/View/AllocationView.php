<?php

namespace Finizens\Finance\Portfolio\Application\Query\View;

final class AllocationView
{
    public function __construct(
        public int $id,
        public int $shares 
    ) {
    }
}
