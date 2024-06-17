<?php

namespace Finizens\Finance\Shared\Application\Query;

final class SearchAllocationById
{
    public function __construct(public int $portfolioId, public int $allocationId)
    {
    }
}
