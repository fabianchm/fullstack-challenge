<?php

declare(strict_types=1);

namespace Finizens\Finance\Order\Application\Query;

final class SearchUncompletedOrderFromPortfolio
{
    public function __construct(public int $portfolioId)
    {
    }
}
